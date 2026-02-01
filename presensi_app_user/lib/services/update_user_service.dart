import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class UpdateUserService {
  final String baseUrl = dotenv.env['BASE_URL'] ?? 'fallback_url';

  Future<http.Response> updateUserApi(Map<String, dynamic> userData) async {
    final url = Uri.parse('$baseUrl/api/users/update');

    SharedPreferences prefs = await SharedPreferences.getInstance();
    final String? token = prefs.getString('auth_token');

    final Map<String, String> requestBody = {
      'Nama_Pengguna': userData['name'].toString(),
      'email': userData['email'].toString(),
    };

    if (userData['password'] != null && userData['password'].toString().isNotEmpty) {
      requestBody['password'] = userData['password'].toString();
    }

    final response = await http.put(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: requestBody,
    );

    return response;
  }
}