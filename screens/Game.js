import React, { useState, useEffect } from 'react';
import { StyleSheet, View, StatusBar, Text, TouchableOpacity } from 'react-native';
import { GameEngine } from 'react-native-game-engine';
import { AdMobRewarded, AdMobInterstitial } from 'react-native-admob';
import { Audio } from 'expo-av';
import { Physics } from '../game/systems/Physics';
import { TapGestureHandler, State, FlingGestureHandler, Directions } from 'react-native-gesture-handler';
import Player from '../game/entities/Player';
import Floor from '../game/entities/Floor';
import Obstacle from '../game/entities/Obstacle';
import Coin from '../game/entities/Coin';
import Matter from 'matter-js';
import { Dimensions } from 'react-native';

const { width, height } = Dimensions.get('window');

export default function Game() {
  const [running, setRunning] = useState(true);
  const [score, setScore] = useState(0);
  const [gameOverCount, setGameOverCount] = useState(0);
  const [entities, setEntities] = useState({});
  const gameEngineRef = React.useRef(null);
  const [sound, setSound] = useState();

  useEffect(() => {
    const engine = Matter.Engine.create({ enableSleeping: false });
    const world = engine.world;
    const player = Player(world, 'blue', { x: 100, y: 300 }, { height: 50, width: 50 });
    const floor = Floor(world, 'green', { x: width / 2, y: height - 25 }, { height: 50, width });
    const ceiling = Floor(world, 'green', { x: width / 2, y: 25 }, { height: 50, width });
    const obstacle = Obstacle(world, 'obstacle', 'red', { x: width, y: height - 100 }, { height: 50, width: 50 });
    const coin = Coin(world, 'coin', 'gold', { x: width + 100, y: height - 100 }, { height: 30, width: 30 });

    async function loadSounds() {
      const { sound } = await Audio.Sound.createAsync(
        require('../assets/sounds/jump.mp3')
      );
      setSound(sound);
    }

    loadSounds();


    setEntities({
      physics: { engine, world },
      player,
      floor,
      ceiling,
      obstacle,
      coin,
    });

    Matter.Events.on(engine, 'collisionStart', (event) => {
      const pairs = event.pairs;
      const objA = pairs[0].bodyA.label;
      const objB = pairs[0].bodyB.label;

      if ((objA === 'Player' && objB === 'obstacle') || (objA === 'obstacle' && objB === 'Player')) {
        gameEngineRef.current.dispatch({ type: 'game-over' });
      } else if ((objA === 'Player' && objB === 'coin') || (objA === 'coin' && objB === 'Player')) {
        gameEngineRef.current.dispatch({ type: 'coin-collected' });
      }
    });

  }, []);

  const onEvent = async (e) => {
    if (e.type === 'game-over') {
      if (sound) {
        await sound.replayAsync();
      }
      setRunning(false);
      setGameOverCount(gameOverCount + 1);
      if (gameOverCount % 3 === 0) {
        AdMobInterstitial.setAdUnitID('ca-app-pub-3940256099942544/1033173712'); // Test ID
        AdMobInterstitial.requestAd().then(() => AdMobInterstitial.showAd());
      }
    } else if (e.type === 'score') {
      setScore(score + 1);
    } else if (e.type === 'coin-collected') {
      if (sound) {
        await sound.replayAsync();
      }
      setScore(score + 5);
    }
  };

  const onGestureEvent = (event) => {
    if (event.nativeEvent.state === State.BEGAN) {
      gameEngineRef.current.dispatch({ type: 'flip-gravity' });
    }
  };

  const onSwipeUp = (event) => {
    if (event.nativeEvent.state === State.END) {
      gameEngineRef.current.dispatch({ type: 'jump' });
    }
  };

  const onSwipeDown = (event) => {
    if (event.nativeEvent.state === State.END) {
      gameEngineRef.current.dispatch({ type: 'slide' });
    }
  };

  return (
    <FlingGestureHandler direction={Directions.UP} onHandlerStateChange={onSwipeUp}>
      <FlingGestureHandler direction={Directions.DOWN} onHandlerStateChange={onSwipeDown}>
        <TapGestureHandler onHandlerStateChange={onGestureEvent}>
          <View style={styles.container}>
            <GameEngine
              ref={gameEngineRef}
              style={styles.gameContainer}
              running={running}
              systems={[Physics]}
              entities={entities}
              onEvent={onEvent}
            >
              <StatusBar hidden={true} />
            </GameEngine>
            <Text style={styles.score}>{score}</Text>
            {!running && (
              <View style={styles.gameOverContainer}>
                <Text style={styles.gameOverText}>Game Over</Text>
                <Text style={styles.gameOverText}>Score: {score}</Text>
            <TouchableOpacity
              style={styles.button}
              onPress={() => {
                AdMobRewarded.setAdUnitID('ca-app-pub-3940256099942544/5224354917'); // Test ID
                AdMobRewarded.requestAd().then(() => AdMobRewarded.showAd());
                AdMobRewarded.addEventListener('rewarded', () => {
                  setRunning(true);
                  setScore(0);
                });
              }}
            >
              <Text style={styles.buttonText}>Revive with Ad</Text>
            </TouchableOpacity>
              </View>
            )}
          </View>
        </TapGestureHandler>
      </FlingGestureHandler>
    </FlingGestureHandler>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
  },
  gameContainer: {
    position: 'absolute',
    top: 0,
    bottom: 0,
    left: 0,
    right: 0,
  },
  score: {
    position: 'absolute',
    top: 50,
    left: 50,
    fontSize: 50,
    fontWeight: 'bold',
  },
  gameOverContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  gameOverText: {
    fontSize: 50,
    fontWeight: 'bold',
  },
  button: {
    backgroundColor: '#000',
    padding: 15,
    borderRadius: 10,
    marginTop: 20,
  },
  buttonText: {
    color: '#fff',
    fontSize: 20,
    fontWeight: 'bold',
  },
});
