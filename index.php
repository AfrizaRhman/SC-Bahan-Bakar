<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            color: #333;
        }

        input[type="number"], select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: rgb(255, 196, 0);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: rgba(255, 196, 0, 0.767);
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .result p {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bahan Bakar Shell</h1>

        <form method="post">
            <label for="jumlahLiter">Masukan Jumlah Liter : </label>
            <input type="number" id="jumlahLiter" name="jumlahLiter" required><br><br>
            <label for="tipeBahanBakar">Pilih tipe bahan bakar anda :</label>
            <select name="tipeBahanBakar" id="tipeBahanBakar" required>
                <option value="Shell Super">Shell Super</option>
                <option value="SV Power Diesel">SV Power Diesel</option>
                <option value="V-Power">V-Power</option>
                <option value="V-Power Nitro">V-Power Nitro</option>
            </select><br><br>
            <input type="submit" id="Beli" value="Beli Sekarang"><br><br>
        </form>
    </div>
</body>
<?php
    
    class Shell {
        private $harga;
        private $jenis;
        private $ppn;

        public function __construct($harga, $jenis, $ppn) {
            $this->harga = $harga;
            $this->jenis = $jenis;
            $this->ppn = $ppn;
        }

        public function getHarga() {
            return $this->harga;
        }

        public function getJenis() {
            return $this->jenis;
        }

        public function getPpn() {
            return $this->ppn;
        }
    }
    
    class Beli extends Shell {
        private $jumlah;
        private $totalBayar;
        private $ppnAmount; 
        public $jumlahLiter;

        public function __construct($harga, $jenis, $ppn, $jumlah) {
            parent::__construct($harga, $jenis, $ppn);
            $this->jumlah = $jumlah;
            $this->totalBayar = $this->calculateTotalBayar();
        }

        private function calculateTotalBayar() {
            $hargaPerLiter = $this->getHarga();
            $this->jumlahLiter = $this->jumlah;
            $ppnPercentage = $this->getPpn() / 100;
            $subTotal = $hargaPerLiter * $this->jumlahLiter;
            $this->ppnAmount = $subTotal * $ppnPercentage; 
            $totalBayar = $subTotal + $this->ppnAmount;
            return $totalBayar;
        }

        public function getTotalBayar() {
            return $this->totalBayar;
        }

        public function getPpnAmount() {
            return $this->ppnAmount;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $jenisBahanBakar = $_POST["tipeBahanBakar"];
        $jumlahLiter = $_POST["jumlahLiter"];

        $harga = 0;
        $ppn = 10; 

        switch ($jenisBahanBakar) {
            case "Shell Super":
                $harga = 17320;
                break;
            case "SV Power Diesel":
                $harga = 19570;
                break;
            case "V-Power":
                $harga = 16746;
                break;
            case "V-Power Nitro":
                $harga = 18450;
                break;
        }

        $beli = new Beli($harga, $jenisBahanBakar, $ppn, $jumlahLiter);

        echo "<div class='result'>";
        echo "<p>Anda membeli bahan bakar tipe: " . $beli->getJenis() . "</p>";
        echo "<p>Jumlah: " . $beli->jumlahLiter . " Liter</p>";
        echo "<p>Total yang harus Anda bayar: Rp. " . number_format($beli->getTotalBayar(), 2, '.', ',') . "</p>";
        echo "<p>PPN yang dikenakan (" . number_format($beli->getPpnAmount(), 2, '.', ',') . "</p>";
        echo "</div>";
    }
?>
</html>
