import 'package:flutter/material.dart';
import 'package:intl/intl.dart';

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