-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 27 Feb 2022 pada 07.49
-- Versi server: 8.0.22
-- Versi PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akuntansi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id` int NOT NULL,
  `no_akun` int NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id`, `no_akun`, `nama`) VALUES
(8, 10000, 'Aktiva / Asset'),
(9, 10100, 'Aktiva Lancar'),
(10, 10101, 'Kas'),
(11, 10102, 'Piutang Dagang'),
(12, 10200, 'Aktiva Tetap'),
(13, 10201, 'Bangunan'),
(14, 10202, 'Tanah'),
(15, 10203, 'Kendaraan'),
(16, 20000, 'Hutang / Liability'),
(17, 20100, 'Hutang Jangka Pendek'),
(18, 20101, 'Hutang Dagang'),
(19, 20200, 'Hutang Jangka Panjang'),
(20, 20201, 'Hutang pihak ketiga'),
(21, 30000, 'Modal / Equity'),
(22, 30100, 'Modal'),
(23, 30200, 'Prive'),
(24, 30300, 'Laba Tahun Berjalan'),
(25, 40000, 'Penjualan / Income'),
(26, 40100, 'Penjualan'),
(27, 40200, 'Potongan Penjualan'),
(28, 60000, 'Biaya / Expense'),
(29, 60100, 'Biaya Kantor'),
(30, 60200, 'Biaya OperasionalÂ '),
(31, 60201, 'Biaya Pajak'),
(32, 60400, 'Biaya Perbaikan dan pemeliharaan'),
(33, 70000, 'Pendapatan Lain-lain / Other Income'),
(34, 70100, 'Pendapatan Bunga'),
(35, 70200, 'Laba Selisih Kurs'),
(36, 80000, 'Biaya Lain-lain / Other Expense'),
(37, 80100, 'Biaya Administrasi dan Bunga'),
(38, 50100, 'Beban Gaji');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `kode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama`, `jenis`, `kode`) VALUES
(1, 'Indomie Goreng', 'Persediaan', 'Barang & Jasa'),
(2, 'Samsung A52s', 'Persediaan', 'Barang & Jasa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnalpembelian`
--

CREATE TABLE `jurnalpembelian` (
  `id` int NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `no_akun` int NOT NULL,
  `no_akun2` int NOT NULL,
  `nama_akun` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `nama_akun2` varchar(100) NOT NULL,
  `saldo` int NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `supplier_id` int NOT NULL,
  `no_faktur` int NOT NULL,
  `barang` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:belum lunas, 1:lunas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnalumum`
--

CREATE TABLE `jurnalumum` (
  `id` int NOT NULL,
  `kode_jurnal` varchar(10) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `jurnal` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_akun` int NOT NULL,
  `akun_debit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_debit` int NOT NULL,
  `no_kredit` int NOT NULL,
  `akun_kredit` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_kredit` int NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnalumum`
--

INSERT INTO `jurnalumum` (`id`, `kode_jurnal`, `tgl_pembelian`, `jurnal`, `no_akun`, `akun_debit`, `total_debit`, `no_kredit`, `akun_kredit`, `total_kredit`, `keterangan`) VALUES
(10, 'KELUARKAS6', '2022-02-25', 'Pengeluaran Kas', 60200, 'Biaya OperasionalÂ ', 300000, 10101, 'Kas', 300000, ''),
(25, 'MASUKKAS21', '2022-02-25', 'Penerimaan Kas', 10101, 'Kas', 5000000, 20200, 'Hutang Jangka Panjang', 5000000, 'Penerimaan Kas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_kas`
--

CREATE TABLE `jurnal_kas` (
  `id` int NOT NULL,
  `tgl_penerimaan` date NOT NULL,
  `no_akun` int NOT NULL,
  `nama_akun` varchar(40) NOT NULL,
  `no_akun2` int NOT NULL,
  `nama_akun2` varchar(100) NOT NULL,
  `pelanggan` int NOT NULL,
  `no_faktur` varchar(100) NOT NULL,
  `saldo` int NOT NULL,
  `jenis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal_kas`
--

INSERT INTO `jurnal_kas` (`id`, `tgl_penerimaan`, `no_akun`, `nama_akun`, `no_akun2`, `nama_akun2`, `pelanggan`, `no_faktur`, `saldo`, `jenis`) VALUES
(21, '2022-02-25', 10101, 'Kas', 20200, 'Hutang Jangka Panjang', 2, '311', 5000000, 'Debit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_pengeluaran_kas`
--

CREATE TABLE `jurnal_pengeluaran_kas` (
  `id` int NOT NULL,
  `tgl_pengeluaran` varchar(20) NOT NULL,
  `no_akun` int NOT NULL,
  `nama_akun` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_akun2` int NOT NULL,
  `nama_akun2` varchar(100) NOT NULL,
  `saldo` int NOT NULL,
  `jenis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal_pengeluaran_kas`
--

INSERT INTO `jurnal_pengeluaran_kas` (`id`, `tgl_pengeluaran`, `no_akun`, `nama_akun`, `no_akun2`, `nama_akun2`, `saldo`, `jenis`) VALUES
(6, '2022-02-25', 60200, 'Biaya OperasionalÂ ', 10101, 'Kas', 300000, 'Debit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_penggajian`
--

CREATE TABLE `jurnal_penggajian` (
  `id` int NOT NULL,
  `tgl_penggajian` date NOT NULL,
  `no_akun` int NOT NULL,
  `nama_akun` varchar(40) NOT NULL,
  `saldo` int NOT NULL,
  `jenis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_penjualan`
--

CREATE TABLE `jurnal_penjualan` (
  `id` int NOT NULL,
  `tgl_penjualan` date NOT NULL,
  `no_akun` int NOT NULL,
  `nama_akun` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `no_akun2` int NOT NULL,
  `nama_akun2` varchar(100) NOT NULL,
  `pelanggan` int NOT NULL,
  `barang` int NOT NULL,
  `saldo` int NOT NULL,
  `jenis` varchar(10) NOT NULL,
  `no_faktur` varchar(100) NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:belum lunas; 1:lunas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `neraca`
--

CREATE TABLE `neraca` (
  `id` int NOT NULL,
  `kode_jurnal` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `no_akun` int NOT NULL,
  `akun` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `saldo` int NOT NULL,
  `jenis_akun` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `neraca`
--

INSERT INTO `neraca` (`id`, `kode_jurnal`, `no_akun`, `akun`, `saldo`, `jenis_akun`) VALUES
(1, 'MASUKKAS21', 10101, 'Kas', 5000000, 0),
(2, 'MASUKKAS21', 20200, 'Hutang Jangka Panjang', 5000000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nohp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `nohp`, `email`, `alamat`) VALUES
(2, 'Liza', '08123456987', 'liza@gmail.com', 'Bandung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nohp` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `nohp`, `email`, `alamat`) VALUES
(2, 'Indofood', '08123456789', 'sales@indofood.com', 'Jakarta'),
(3, 'Samsung', '0878712345', 'sales@samsung.id', 'Tanggerang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL,
  `id` int NOT NULL,
  `pass` varchar(10) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `id`, `pass`, `level`) VALUES
('admin', 1, 'admin', 'admin'),
('manager', 2, 'manager', 'manager'),
('accounting', 3, 'accounting', 'accounting');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnalpembelian`
--
ALTER TABLE `jurnalpembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnalumum`
--
ALTER TABLE `jurnalumum`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal_kas`
--
ALTER TABLE `jurnal_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal_pengeluaran_kas`
--
ALTER TABLE `jurnal_pengeluaran_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal_penggajian`
--
ALTER TABLE `jurnal_penggajian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jurnal_penjualan`
--
ALTER TABLE `jurnal_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `neraca`
--
ALTER TABLE `neraca`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jurnalpembelian`
--
ALTER TABLE `jurnalpembelian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `jurnalumum`
--
ALTER TABLE `jurnalumum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `jurnal_kas`
--
ALTER TABLE `jurnal_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `jurnal_pengeluaran_kas`
--
ALTER TABLE `jurnal_pengeluaran_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `jurnal_penggajian`
--
ALTER TABLE `jurnal_penggajian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jurnal_penjualan`
--
ALTER TABLE `jurnal_penjualan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `neraca`
--
ALTER TABLE `neraca`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
