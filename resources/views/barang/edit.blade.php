<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #fff9f3, #f5fefc);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0b8e78;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #0b8e78;
            outline: none;
            background-color: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .alert {
            background-color: #ffecec;
            color: #b30000;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            transition: background 0.3s ease-in-out;
        }

        .btn-back {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-back:hover {
            background-color: #ccc;
        }

        .btn-save {
            background-color: #0b8e78;
            color: #fff;
        }

        .btn-save:hover {
            background-color: #08705f;
        }

        img.preview {
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            max-width: 120px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>✏️ Edit Barang</h2>

    @if ($errors->any())
        <div class="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
        </div>

        <div class="form-group">
    <label>Kategori</label>
    <select name="kategori_id" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>


        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $barang->harga) }}" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" value="{{ old('stok', $barang->stok) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Gambar Barang</label>
            <input type="file" name="gambar" accept="image/*">
            @if ($barang->gambar)
                <small>Gambar saat ini:</small><br>
                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="preview">
            @endif
        </div>

        <div class="button-group">
            <a href="{{ route('barang.index') }}" class="btn btn-back">← Kembali</a>
            <button type="submit" class="btn btn-save">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>

</body>
</html>
