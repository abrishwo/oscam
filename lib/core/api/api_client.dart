import 'dart:convert';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:http/http.dart' as http;

class ApiClient {
  final _baseUrl = dotenv.env['API_URL'];

  Future<dynamic> post(String endpoint, Map body) async {
    final url = Uri.parse("$_baseUrl$endpoint");
    final response = await http.post(url, body: body);

    return jsonDecode(response.body);
  }
}
