<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected $apiKey;

    protected $model;

    public function __construct()
    {
        // 🚨 API key langsung diletakkan di sini (hardcoded)
        $this->apiKey = 'AIzaSyDpzdjdIaN19A810cjupctzSdipZZI36Jw';
        $this->model = 'gemini-2.5-flash';
    }

    public function extractIdentityData(string $ocrText): array
    {
        try {
            Log::info('AIService: Starting extraction for OCR text', ['text_length' => strlen($ocrText)]);

            $prompt = $this->identityPrompt($ocrText);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $this->apiKey, // ⬅️ API key dikirim via header
            ])
                ->timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('AIService: API response received', ['response' => $result]);

                $extractedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                return [
                    'success' => true,
                    'raw_response' => $extractedText,
                    'json_data' => json_decode($this->cleanJsonResponse($extractedText), true),
                ];
            } else {
                Log::error('AIService: API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => 'AIService request failed: '.$response->status(),
                    'raw_response' => $response->body(),
                    'json_data' => null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('AIService: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Exception: '.$e->getMessage(),
                'raw_response' => null,
                'json_data' => null,
            ];
        }
    }

    private function identityPrompt(string $ocrText): string
    {
        return <<<PROMPT
                Berikut adalah hasil OCR dari sebuah Kartu Tanda Penduduk (KTP):

                {$ocrText}

                Berikut adalah teks hasil OCR dari sebuah KTP (Kartu Tanda Penduduk). Bisa saja terdapat kesalahan ejaan, kapitalisasi, atau struktur kalimat.

                Tugas kamu:
                - Ekstrak data menjadi JSON terstruktur.
                - Rapikan teks (kapitalisasi, ejaan, tanda baca).
                - Pisahkan elemen alamat dengan tepat: address, RT, RW, kelurahan, kecamatan, provinsi.
                - Jangan satukan RT, RW, kelurahan, kecamatan, atau provinsi ke dalam address.
                - **Validasi dan koreksi nama kelurahan, kecamatan, dan provinsi agar sesuai dengan data alamat resmi yang ada di Indonesia.**
                - Jika ada kesalahan penulisan atau variasi nama wilayah, koreksi dan gunakan nama wilayah yang benar dan umum dipakai secara resmi.
                - Jika data tidak lengkap, isi dengan string kosong "".
                - Gunakan format tanggal `YYYY-MM-DD` untuk `birth_date` dan `valid_until`.

                Contoh hasil validasi dan perbaikan alamat:
                "address": "Pandansari Utara",
                "rt": "",
                "rw": "",
                "kelurahan": "Jrurejo",
                "kecamatan": "Minggir",
                "provinsi": "Daerah Istimewa Yogyakarta"

                Selain itu, buatlah sebuah kalimat deskripsi singkat yang merangkum informasi utama dari data KTP berikut ini:
                - Nama lengkap
                - Tempat dan tanggal lahir (tampilkan tanggal lahir dalam format tanggal bahasa Indonesia, misalnya 17 Agustus 1990)
                - Jenis kelamin
                - Alamat lengkap (gabungkan address, RT, RW, kelurahan, kecamatan, dan provinsi jika tersedia)
                - Pekerjaan

                Berikan hasil dalam JSON **dengan struktur seperti ini** (jangan ubah struktur, jangan tambahkan keterangan atau komentar apa pun):

                Format JSON:
                {
                "nik": "",
                "name": "",
                "birth_place": "",
                "birth_date": "YYYY-MM-DD",
                "gender": "",
                "blood_type": "",
                "address": "",
                "rt": "",
                "rw": "",
                "kelurahan": "",
                "kecamatan": "",
                "provinsi": "",
                "religion": "",
                "marital_status": "",
                "occupation": "",
                "nationality": "",
                "valid_until": "",
                "deskripsi": ""
                }

                **Instruksi Khusus:**
                - Ambil semua data sesuai dengan teks pada KTP.
                - Pastikan `address` hanya berisi nama jalan atau dusun — **jangan masukkan RT, RW, kelurahan, kecamatan, atau provinsi di sini**.
                - Pisahkan RT, RW, kelurahan, kecamatan, dan provinsi ke field masing-masing.
                - Gunakan format tanggal `YYYY-MM-DD` untuk field `birth_date` tapi dalam deskripsi singkat tampilkan tanggal dalam format bahasa Indonesia (dd MMMM yyyy).
                - Buat kalimat deskripsi singkat yang jelas dan mudah dibaca sesuai contoh.
                - Tampilkan hanya JSON, tanpa penjelasan tambahan.
        PROMPT;
    }

    private function cleanJsonResponse(string $response): string
    {
        $cleaned = preg_replace('/```json\s*/', '', $response);
        $cleaned = preg_replace('/```$/', '', $cleaned);
        $cleaned = trim($cleaned);

        $start = strpos($cleaned, '{');
        $end = strrpos($cleaned, '}');

        if ($start !== false && $end !== false) {
            $cleaned = substr($cleaned, $start, $end - $start + 1);
        }

        return $cleaned;
    }

    // Invoice / Nota
    /**
     * Extract transaction data from OCR text using AI
     */
    public function extractTransactionData(string $ocrText): array
    {
        try {
            Log::info('AIService: Starting transaction extraction', ['text_length' => strlen($ocrText)]);

            $prompt = $this->buildTrasactionPrompt($ocrText);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => $this->apiKey,
            ])
                ->timeout(30)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info('AIService: Transaction API response received', ['response' => $result]);

                $extractedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                return [
                    'success' => true,
                    'raw_response' => $extractedText,
                    'json_data' => json_decode($this->cleanJsonResponse($extractedText), true),
                ];
            } else {
                Log::error('AIService: Transaction API request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [
                    'success' => false,
                    'error' => 'AIService request failed: '.$response->status(),
                    'raw_response' => $response->body(),
                    'json_data' => null,
                ];
            }
        } catch (\Exception $e) {
            Log::error('AIService: Exception during transaction extraction', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'error' => 'Exception: '.$e->getMessage(),
                'raw_response' => null,
                'json_data' => null,
            ];
        }
    }

    // menganalisis OCR text sebelum membuat prompt
    private function detectTransactionType(string $ocrText): string
    {
        $text = strtolower($ocrText);

        // Ciri umum pemasukan
        if (str_contains($text, 'gaji') || str_contains($text, 'slip') || str_contains($text, 'thr') || str_contains($text, 'transfer dari') || str_contains($text, 'bunga') || str_contains($text, 'pendapatan')) {
            return 'income';
        }

        // Default diasumsikan pengeluaran
        return 'expense';
    }

    /**
     * Build the prompt for Gemini AI
     */
    private function buildTrasactionPrompt(string $ocrText): string
    {
        $type = $this->detectTransactionType($ocrText);

        if ($type === 'income') {
            return <<<PROMPT
            Berikut adalah hasil OCR dari slip gaji atau dokumen pemasukan:

            {$ocrText}

            Ekstrak informasi berikut dalam format JSON tanpa penjelasan:

            {
            "source": "",             // Nama perusahaan / sumber transfer
            "type": "",               // Jenis pemasukan, contoh: "Gaji", "THR", "Bunga Bank"
            "date": "YYYY-MM-DD",     // Tanggal transaksi
            "amount": 0.0,            // Total nominal diterima
            "notes": ""               // Catatan tambahan jika ada
            }

            Instruksi:
            - Ambil nilai `source` dari perusahaan, instansi, atau bank pengirim.
            - `type` seperti "Gaji", "THR", "Bonus", "Bunga", dll berdasarkan konteks.
            - `amount` adalah nominal bersih yang diterima (setelah potongan).
            - Jika tidak ada informasi spesifik, kosongkan field.
            PROMPT;
        }

        // Default: struk pengeluaran
        return <<<PROMPT
            Berikut adalah hasil OCR dari sebuah struk/bill belanja:

            {$ocrText}

            Tugas Anda:
            Ekstrak informasi berikut dalam format JSON. TIDAK perlu menghitung subtotal, total atau pajak.

            **Ambil hanya informasi berikut ini:**
            - Daftar barang: `name`, `quantity`, dan `price`

            Format JSON:
            {
            "items": [
                {
                "name": "",
                "quantity": 0.0,
                "price": 0.0
                }
            ],
            "discount": 0.0,
            "tax": 0.0
            }

            Catatan:
            - Quantity bisa 1 jika tidak disebut.
            - Gunakan angka desimal (titik, bukan koma).
            - Tidak perlu menyertakan penjelasan tambahan di luar JSON.
        PROMPT;
    }
}
