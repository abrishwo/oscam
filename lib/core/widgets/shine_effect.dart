import 'package:flutter/material.dart';
import 'package:shimmer/shimmer.dart';

class ShineEffect extends StatelessWidget {
  final String text;
  const ShineEffect({required this.text});

  @override
  Widget build(BuildContext context) {
    return Shimmer.fromColors(
      baseColor: Colors.green,
      highlightColor: Colors.white,
      child: Text(
        text,
        style: TextStyle(fontSize: 32, fontWeight: FontWeight.bold),
      ),
    );
  }
}
