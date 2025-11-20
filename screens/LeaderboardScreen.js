import React from 'react';
import { View, Text, StyleSheet, FlatList } from 'react-native';

const dummyData = [
  { id: '1', name: 'Player 1', score: 1000 },
  { id: '2', name: 'Player 2', score: 800 },
  { id: '3', name: 'Player 3', score: 600 },
  { id: '4', name: 'Player 4', score: 400 },
  { id: '5', name: 'Player 5', score: 200 },
];

export default function LeaderboardScreen() {
  const renderItem = ({ item }) => (
    <View style={styles.item}>
      <Text style={styles.name}>{item.name}</Text>
      <Text style={styles.score}>{item.score}</Text>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Leaderboard</Text>
      <FlatList
        data={dummyData}
        renderItem={renderItem}
        keyExtractor={(item) => item.id}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#fff',
  },
  title: {
    fontSize: 50,
    fontWeight: 'bold',
    marginBottom: 50,
  },
  item: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    padding: 10,
    width: 300,
  },
  name: {
    fontSize: 20,
  },
  score: {
    fontSize: 20,
    fontWeight: 'bold',
  },
});
