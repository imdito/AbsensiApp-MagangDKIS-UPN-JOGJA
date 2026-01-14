import 'package:flutter/material.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:http/http.dart' as http;

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

    return await http.post(
      url,
      headers: {
        'Accept': 'application/json',
      },
      body: {
        'qr_token': qrCode,
        'user_id': userId,
        'tanggal': DateTime.now().toIso8601String(),
        'status': 'Hadir',
        'jam_absen': TimeOfDay.now().format(context),
        'Latitude': latitude.toString(),
        'Longitude': longitude.toString(),
      },
    );
  }
}