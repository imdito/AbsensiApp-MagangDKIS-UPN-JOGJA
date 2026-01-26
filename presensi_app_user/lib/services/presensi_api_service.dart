import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

import '../model/presensi_model.dart';

class PresensiApiService {
  final String baseUrl = dotenv.env['BASE_URL'] ?? 'fallback_url';

  Future<http.Response> submitPresensi({
    required String qrCode,
    required String userId,
    required double latitude,
    required double longitude,
    required BuildContext context, // Untuk TimeOfDay
  }) async {
    final url = Uri.parse('$baseUrl/api/presensiViaQR');

    SharedPreferences prefs = await SharedPreferences.getInstance();
    final String? token = prefs.getString('auth_token');


    return await http.post(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: {
        'qr_token': qrCode,
        'user_id': userId,
        'Latitude': latitude.toString(),
        'Longitude': longitude.toString(),
      },
    );
  }

  Future<List<PresensiModel>> fetchRiwayatPresensi({
    required int userId, // Sebaiknya berikan tipe data (int/String)
  }) async {
    // 1. PERBAIKAN URL QUERY PARAMETER
    // Menggunakan key 'user_id' agar dikenali di Laravel ($request->user_id)
    final url = Uri.parse('$baseUrl/api/presensi/riwayat/$userId');

    try {
      SharedPreferences prefs = await SharedPreferences.getInstance();
      final String? token = prefs.getString('auth_token');

      // Debugging: Cek URL dan Token di console
      print("Fetching data from: $url");

      final response = await http.get(
        url,
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );

      // 2. CEK STATUS CODE
      if (response.statusCode == 200) {
        var jsonResponse = jsonDecode(response.body);

        // 3. HANDLING FORMAT JSON LARAVEL
        List<dynamic> dataApi = (jsonResponse is Map && jsonResponse.containsKey('data'))
            ? jsonResponse['data']
            : jsonResponse;

        List<PresensiModel> listPresensi = dataApi.map((json) {
          return PresensiModel(
            id: json['id'].toString(),
            tanggal: DateTime.tryParse(json['tanggal'].toString()) ?? DateTime.now(),
            jamMasuk: json['jam_masuk'],
            status: json['status'],
          );
        }).toList();

        return listPresensi;
      } else {
        // Jika error (401, 404, 500)
        print("Error Fetching: ${response.statusCode} - ${response.body}");
        throw Exception('Gagal memuat data: ${response.statusCode}');
      }
    } catch (e) {
      // 4. HANDLING KONEKSI ERROR
      print("Exception: $e");
      throw Exception('Terjadi kesalahan koneksi');
    }
  }


}