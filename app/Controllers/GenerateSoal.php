<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ApiKeyModel;

class GenerateSoal extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');
        return view('generate_soal', ['soal_result' => null]);
    }

    public function process()
    {
        if (!session()->get('logged_in')) return redirect()->to('/login');

        // Ambil parameter dari wizard
        $mapel       = $this->request->getPost('mapel') ?? $this->request->getPost('mata_pelajaran');
        $jenjang     = $this->request->getPost('jenjang') ?? $this->request->getPost('kelas');
        $jumlah      = (int) ($this->request->getPost('jumlah_soal') ?? 10);
        $kesulitan   = $this->request->getPost('kesulitan') ?? 'Sedang';
        $tipeSoal    = $this->request->getPost('tipe_soal') ?? $this->request->getPost('jenis_soal') ?? 'Pilihan Ganda';
        $materiText  = $this->request->getPost('materi') ?? '';

        // Ambil konten dari file upload jika ada
        $fileContent = '';
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getExtension());
            $tmp = $file->getTempName();

            if ($ext === 'txt') {
                $fileContent = file_get_contents($tmp) ?: '';
            } elseif ($ext === 'pdf') {
                $pdfText = shell_exec('pdftotext -layout ' . escapeshellarg($tmp) . ' -');
                $fileContent = $pdfText ?: '';
                if (empty(trim($fileContent))) {
                    $raw = file_get_contents($tmp);
                    $raw = preg_replace('/[^\x20-\x7E\x0A\x0D\x80-\xFF]/', ' ', $raw);
                    $raw = preg_replace('/\s+/', ' ', $raw);
                    if (strlen($raw) > 100) $fileContent = trim($raw);
                }
            } elseif ($ext === 'docx') {
                $zip = new \ZipArchive();
                if ($zip->open($tmp) === true) {
                    $xml = $zip->getFromName('word/document.xml');
                    $zip->close();
                    if ($xml) {
                        $xml = preg_replace('/<w:p[^>]*>/', "\n", $xml);
                        $xml = preg_replace('/<[^>]+>/', '', $xml);
                        $fileContent = html_entity_decode(trim($xml));
                    }
                }
                if (empty(trim($fileContent))) {
                    $raw = file_get_contents($tmp);
                    $raw = preg_replace('/[^\x20-\x7E\x0A\x0D\x80-\xFF]/', ' ', $raw);
                    $raw = preg_replace('/\s+/', ' ', $raw);
                    if (strlen($raw) > 100) $fileContent = trim($raw);
                }
            } else {
                $raw = file_get_contents($tmp);
                $raw = preg_replace('/[^\x20-\x7E\x0A\x0D\x80-\xFF]/', ' ', $raw);
                $raw = preg_replace('/\s+/', ' ', $raw);
                if (strlen($raw) > 100) $fileContent = trim($raw);
            }
        }

        $materi = $fileContent ?: $materiText;
        if (empty(trim($materi))) {
            return redirect()->to('/generate-soal')->with('error', 'Materi tidak boleh kosong!');
        }

        $jumlah = max(1, min($jumlah, 20));

        $maxMateriLength = 12000;
        $materi = trim($materi);
        if (mb_strlen($materi, 'UTF-8') > $maxMateriLength) {
            $materi = mb_substr($materi, 0, $maxMateriLength, 'UTF-8') . "\n\n[Materi dipotong otomatis karena terlalu panjang.]";
        }

        // Susun prompt
        $prompt  = "Kamu adalah asisten guru ahli membuat soal ujian berkualitas dalam Bahasa Indonesia.\n";
        $prompt .= "Mata Pelajaran: {$mapel}\n";
        $prompt .= "Jenjang: {$jenjang}\n";
        $prompt .= "Tingkat Kesulitan: {$kesulitan}\n";
        $prompt .= "Tipe Soal: {$tipeSoal}\n\n";
        $prompt .= "Materi:\n{$materi}\n\n";
        $prompt .= "Buatkan tepat {$jumlah} soal {$tipeSoal}. ";

        if (str_contains($tipeSoal, 'Pilihan Ganda')) {
            $prompt .= "Setiap soal harus memiliki 4 pilihan jawaban (A, B, C, D) dan sertakan kunci jawaban. Format:\n";
            $prompt .= "1. [Pertanyaan]\n   A. ...\n   B. ...\n   C. ...\n   D. ...\n   Jawaban: [huruf]\n\n";
        } elseif (str_contains($tipeSoal, 'Benar/Salah') || str_contains($tipeSoal, 'Benar') || str_contains($tipeSoal, 'Salah')) {
            $prompt .= "Setiap soal harus memiliki pilihan Benar atau Salah dan sertakan kunci jawaban. Format:\n";
            $prompt .= "1. [Pernyataan]\n   Jawaban: [Benar/Salah]\n\n";
        } elseif (str_contains($tipeSoal, 'Campuran')) {
            $prompt .= "Campurkan berbagai tipe soal: Pilihan Ganda, Essay, dan Benar/Salah. Variasikan secara merata. ";
            $prompt .= "Untuk Pilihan Ganda sertakan 4 opsi (A, B, C, D) dan kunci. ";
            $prompt .= "Format:\n1. [Pertanyaan/Pernyataan]\n   Opsi jika ada\n   Jawaban: ...\n\n";
        } else {
            $prompt .= "Setiap soal cukup berupa pertanyaan esai tanpa pilihan jawaban. Sertakan kunci jawaban di bawah setiap soal. Format:\n";
            $prompt .= "1. [Pertanyaan]\n   Jawaban: ...\n\n";
        }

        $prompt .= "Langsung tulis soal-soalnya tanpa pengantar.";

        // Ambil API key dari database atau .env
        $apiKeyModel = new ApiKeyModel();
        $savedKey = $apiKeyModel->first();
        $apiKey = $savedKey ? $savedKey['api_key'] : (env('GROQ_API_KEY') ?: '');

        if (empty($apiKey)) {
            return redirect()->to('/generate-soal')->with('error', 'API Key belum dikonfigurasi. Silakan tambahkan di Pengaturan > API Key.');
        }

        $url    = 'https://api.groq.com/openai/v1/chat/completions';
        $client = \Config\Services::curlrequest();

        $payload = [
            'model'    => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => 'Anda adalah asisten AI pendidik yang membantu guru menyusun soal latihan berkualitas sesuai standar pendidikan Indonesia.'],
                ['role' => 'user',   'content' => $prompt],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 4096,
        ];

        $jsonPayload = json_encode($payload, JSON_INVALID_UTF8_SUBSTITUTE);
        if ($jsonPayload === false) {
            return redirect()->to('/generate-soal')->with('error', 'Materi tidak bisa diproses. Pastikan isi materi berupa teks yang valid.');
        }

        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'body'       => $jsonPayload,
                'verify'      => false,
                'http_errors' => false,
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                $errorBody = json_decode($response->getBody(), true);
                $errorMsg  = $errorBody['error']['message'] ?? 'Unknown error dari API';
                return redirect()->to('/generate-soal')->with('error', 'API Error: ' . $errorMsg);
            }

            $body      = json_decode($response->getBody(), true);
            $rawText   = $body['choices'][0]['message']['content'] ?? '';

            return view('generate_soal', [
                'soal_result'    => $rawText,
                'mapel'          => $mapel,
                'jenjang'        => $jenjang,
                'jumlah'         => $jumlah,
                'kesulitan'      => $kesulitan,
                'tipe_soal'      => $tipeSoal,
            ]);

        } catch (\Exception $e) {
            return redirect()->to('/generate-soal')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
