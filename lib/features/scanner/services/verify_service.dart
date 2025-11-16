import '../../../core/api/api_client.dart';

class VerifyService {
  final ApiClient _client = ApiClient();

  Future<Map> verifyProduct(String qr) async {
    return await _client.post("/verify", {"qr": qr});
  }
}
