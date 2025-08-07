<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Barang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Custom CSS -->
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #eafaf1, #f7fff9);
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease-in-out;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2d9c66;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cde4d7;
            border-radius: 8px;
            background-color: #f9fdfb;
            font-size: 15px;
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #5ecf96;
            outline: none;
            background-color: #ffffff;
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
            transition: all 0.3s ease-in-out;
        }

        .btn-cancel {
            background-color: #f1f1f1;
            color: #555;
        }

        .btn-cancel:hover {
            background-color: #ddd;
        }

        .btn-save {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-save:hover {
            background-color: #27ae60;
        }

        .alert {
            background-color: #ffe6e6;
            color: #b30000;
            padding: 10px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        ul {
            margin: 0;
            padding-left: 18px;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(15px);}
            to   {opacity: 1; transform: translateY(0);}
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
    <h2>🛍️ Tambah Data Barang</h2>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" placeholder="Contoh: BRG001" required>
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Contoh: Facial Wash XYZ" required>
            </div>
        </div>

        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Facial Wash">Facial Wash</option>
                <option value="Body Wash">Body Wash</option>
                <option value="Cream">Cream</option>
                <option value="Toner">Toner</option>
                <option value="Masker Wajah">Masker Wajah</option>
                <option value="Deodorant">Deodorant</option>
                <option value="Serum">Serum</option>
            </select>
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" placeholder="Opsional: Tuliskan keunggulan produk..."></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" placeholder="cth: 25000" required>
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" placeholder="cth: 10" required>
            </div>
        </div>

        <div class="form-group">
            <label>Gambar Barang</label>
            <input type="file" name="gambar" accept="image/*">
        </div>

        <div class="button-group">
            <a href="{{ route('barang.index') }}" class="btn btn-cancel">← Batal</a>
            <button type="submit" class="btn btn-save">💾 Simpan Data</button>
        </div>
    </form>
</div>

</body>
</html>
