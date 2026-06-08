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
        $jumlah      = $this->request->getPost('jumlah_soal') ?? 10;
        $kesulitan   = $this->request->getPost('kesulitan') ?? 'Sedang';
        $tipeSoal    = $this->request->getPost('tipe_soal') ?? $this->request->getPost('jenis_soal') ?? 'Pilihan Ganda';
        $materiText  = $this->request->getPost('materi') ?? '';

        // Ambil konten dari file upload jika ada
        $fileContent = '';
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $mime = $file->getClientMimeType();
            if (str_contains($mime, 'text') || in_array($file->getExtension(), ['txt', 'pdf', 'doc', 'docx'])) {
                $fileContent = file_get_contents($file->getTempName());
            }
        }

        $materi = $fileContent ?: $materiText;
        if (empty(trim($materi))) {
            return redirect()->to('/generate-soal')->with('error', 'Materi tidak boleh kosong!');
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
            $prompt .= "Setiap soal harus memiliki 4 pilihan jawaban (A, B, C, D) dan sertakan kunci jawaban. ";
        }
        $prompt .= "Format output:\n";
        $prompt .= "1. [Pertanyaan]\n   A. ...\n   B. ...\n   C. ...\n   D. ...\n   Jawaban: [huruf]\n\n";
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

        try {
            $response = $client->request('POST', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'model'    => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Anda adalah asisten AI pendidik yang membantu guru menyusun soal latihan berkualitas sesuai standar pendidikan Indonesia.'],
                        ['role' => 'user',   'content' => $prompt],
                    ],
                    'temperature' => 0.7,
                ],
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

            // Kembalikan ke wizard view (step 3) dengan raw text
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
