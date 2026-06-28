<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Campaign Baru</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
            background:#F3F3F3;
        }

        .card{
            background:white;
            border-radius:24px;
            padding:32px;
            border:1px solid #ECECEC;
            box-shadow:0 2px 12px rgba(0,0,0,.03);
        }

        .input{
            width:100%;
            height:52px;
            border:1px solid #E4E4E7;
            border-radius:12px;
            padding:0 18px;
            outline:none;
            transition:.2s;
        }

        .input:focus{
            border-color:#3A1D2E;
            box-shadow:0 0 0 3px rgba(58,29,46,.08);
        }

        .textarea{
            width:100%;
            min-height:150px;
            border:1px solid #E4E4E7;
            border-radius:12px;
            padding:16px;
            resize:none;
            outline:none;
        }

        .upload-box{
            border:2px dashed #E5E7EB;
            border-radius:18px;
            height:170px;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            cursor:pointer;
            transition:.25s;
        }

        .upload-box:hover{
            background:#fafafa;
            border-color:#A6B347;
        }

        label{
            font-size:14px;
            color:#555;
            font-weight:600;
        }
    </style>
</head>

<body>

<form action="{{ route('campaign.store') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<!-- ================= HEADER ================= -->

<header class="bg-[#3A1D2E]">

    <!-- Navbar -->
    <div class="max-w-7xl mx-auto flex items-center justify-between h-20">

        <h1 class="text-white text-xl font-bold">
         HatiNurani
        </h1>

        <nav class="flex items-center gap-10 text-white text-[15px] font-medium">
            <a href="{{ route('beranda') }}">Beranda</a>
            <a href="{{ route('donasi') }}">Donasi</a>
            <a href="{{ route('tentang') }}">Tentang</a>
            <a href="{{ route('kontak') }}">Kontak</a>

            <a href="{{ route('user.dashboard') }}"
               class="bg-[#A7B742] px-6 py-2 rounded-full text-[15px] font-semibold">
                Dashboard
            </a>
        </nav>

    </div>

    <!-- Judul -->
    <div class="max-w-7xl mx-auto pb-8">

        <h1 class="text-4xl font-bold text-white leading-tight">
            Buat Campaign Baru
        </h1>

        <p class="text-[18px] text-gray-300 mt-2">
            Isi formulir berikut untuk mengajukan campaign galang dana
        </p>

    </div>

</header>
<!-- ================= CONTENT ================= -->

<div class="max-w-5xl mx-auto py-10 space-y-8">

<!-- ================= CARD 1 ================= -->

<div class="card">

    <h2 class="text-[20px] font-bold text-[#3A1D2E]">
        Profil Penerima Donasi
    </h2>

    <!-- Target -->

    <div class="mb-6">

        <label>
            Target Penerima *
        </label>

        <select
            name="recipient_type"
            class="input mt-2">

            <option value="">
                Pilih Target Penerima
            </option>

            <option>
                Individu
            </option>

            <option>
                Organisasi
            </option>

            <option>
                Yayasan
            </option>

            <option>
                Komunitas
            </option>

        </select>

    </div>

    <!-- Nama -->

    <div class="mb-6">

        <label>
            Nama Lengkap *
        </label>

        <input
            type="text"
            name="recipient_name"
            class="input mt-2"
            placeholder="Tuliskan nama lengkap penerima donasi">

    </div>

    <!-- Upload -->

    <div>

        <label>
            Berkas Legalitas & Bukti *
        </label>

        <label class="upload-box mt-2">

            <input
                type="file"
                name="identity_file"
                class="hidden">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 mb-4 text-gray-500"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            <p class="font-semibold text-gray-700">
                Upload Kartu Identitas Penerima
            </p>

            <p class="text-sm text-gray-500 mt-2">
                PDF, DOC, DOCX, XLSX • Maks. 10MB
            </p>

        </label>

 <!-- ================= CARD 2 ================= -->

<div class="card">

    <h2 class="text-[20px] font-bold text-[#3A1D2E]">
        Informasi Campaign
    </h2>

    <!-- Judul -->

    <div class="mb-6">

        <label>
            Judul Campaign *
        </label>

        <input
            type="text"
            name="title"
            class="input mt-2"
            placeholder="Tuliskan judul yang jelas dan menarik"
            value="{{ old('title') }}"
            required>

    </div>

    <!-- Kategori -->

    <div class="mb-6">

        <label>
            Kategori *
        </label>

        <select
            name="category_id"
            class="input mt-2"
            required>

            <option value="">
                Pilih kategori
            </option>

            @foreach($categories as $category)

                <option
                    value="{{ $category->category_id }}"
                    {{ old('category_id') == $category->category_id ? 'selected' : '' }}>

                    {{ $category->category_name }}

                </option>

            @endforeach

        </select>

    </div>

    <!-- Deskripsi Singkat -->

    <div class="mb-6">

        <label>
            Deskripsi Singkat *
        </label>

        <textarea
            name="short_description"
            rows="3"
            class="textarea mt-2"
            placeholder="Tuliskan ringkasan campaign">{{ old('short_description') }}</textarea>

    </div>

    <!-- Cerita Campaign -->

    <div class="mb-8">

        <label>
            Deskripsi Campaign *
        </label>

        <textarea
            name="story"
            rows="8"
            class="textarea mt-2"
            placeholder="Ceritakan latar belakang, tujuan, dan rencana penggunaan dana secara detail">{{ old('story') }}</textarea>

    </div>

    <!-- Target + Deadline -->

    <div class="grid grid-cols-2 gap-6">

        <!-- Target -->

        <div>

            <label>
                Target Dana (Rp) *
            </label>

            <input
                type="number"
                name="target_amount"
                class="input mt-2"
                placeholder="0"
                value="{{ old('target_amount') }}"
                required>

        </div>

        <!-- Deadline -->

        <div>

            <label>
                Deadline *
            </label>

            <input
                type="date"
                name="end_date"
                class="input mt-2"
                value="{{ old('end_date') }}"
                required>

        </div>

    </div>

    
</div>

<!-- ================= CARD 3 ================= -->

<div class="card">

    <h2 class="text-[20px] font-bold text-[#3A1D2E]">
        Media & Dokumen
    </h2>

    <!-- FOTO CAMPAIGN -->

    <div class="mb-8">

        <label>
            Foto Campaign *
        </label>

        <label
            class="upload-box mt-3"
            for="campaign_image">

            <input
                type="file"
                id="campaign_image"
                name="campaign_image"
                accept="image/*"
                class="hidden">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-12 h-12 text-gray-400 mb-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 15l4-4a3 3 0 014 0l5 5m-1-1l1-1a3 3 0 014 0l1 1M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>

            </svg>

            <h4 class="font-semibold text-lg">
                Upload Foto Campaign
            </h4>

            <p class="text-gray-500 text-sm mt-2">
                PNG, JPG, JPEG (Maksimal 5MB)
            </p>

        </label>

        <!-- Preview -->

        <div class="mt-6 hidden" id="previewContainer">

            <img
                id="previewImage"
                class="rounded-xl border w-full max-h-80 object-cover">

        </div>

    </div>

    <!-- PROPOSAL -->

    <div class="mb-8">

        <label>
            Proposal Campaign (PDF)
        </label>

        <label
            class="upload-box mt-3"
            for="proposal_file">

            <input
                type="file"
                id="proposal_file"
                name="proposal_file"
                accept=".pdf"
                class="hidden">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-12 h-12 text-gray-400 mb-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6M9 8h6m2 12H7a2 2 0 01-2-2V6a2 2 0 012-2h6l5 5v9a2 2 0 01-2 2z"/>

            </svg>

            <h4 class="font-semibold text-lg">
                Upload Proposal
            </h4>

            <p class="text-gray-500 text-sm mt-2">
                Format PDF (Maksimal 10MB)
            </p>

        </label>

    </div>

    <!-- Tombol -->

    <div class="flex justify-end gap-4 mt-10">

        <a
            href="{{ route('user.dashboard') }}"
            class="px-8 py-3 rounded-xl border border-gray-300 font-semibold hover:bg-gray-100">

            Batalkan

        </a>

        <button
            type="submit"
            class="bg-[#F47B3A] hover:bg-[#df692c] text-white font-semibold px-10 py-3 rounded-xl shadow">

            Submit Campaign

        </button>

    </div>

