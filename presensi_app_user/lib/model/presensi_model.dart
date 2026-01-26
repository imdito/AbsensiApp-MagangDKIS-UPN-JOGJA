import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

// --- 1. Model Data (Sesuaikan dengan Response API Laravel Anda) ---
class PresensiModel {
  final String id;
  final DateTime tanggal;
  final String? jamMasuk;
  final String status; // Hadir, Terlambat, Izin, Sakit, Alpha

  PresensiModel({
    required this.id,
    required this.tanggal,
    this.jamMasuk,
    required this.status,
  });
}