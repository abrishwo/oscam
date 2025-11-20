import Matter from 'matter-js';
import { Dimensions } from 'react-native';

const { width, height } = Dimensions.get('window');

export const Physics = (entities, { time, dispatch }) => {
  let engine = entities.physics.engine;

  if (dispatch) {
    dispatch.forEach(event => {
      if (event.type === 'flip-gravity') {
        engine.world.gravity.y *= -1;
      } else if (event.type === 'jump') {
        Matter.Body.applyForce(entities.player.body, entities.player.body.position, { x: 0, y: -0.1 });
      } else if (event.type === 'slide') {
        Matter.Body.scale(entities.player.body, 1, 0.5);
        setTimeout(() => {
          Matter.Body.scale(entities.player.body, 1, 2);
        }, 500);
      }
    });
  }

  Matter.Engine.update(engine, time.delta);

  Matter.Body.setVelocity(entities.player.body, {
    x: 5,
    y: entities.player.body.velocity.y,
  });

  Matter.Body.translate(entities.obstacle.body, { x: -5, y: 0 });
  Matter.Body.translate(entities.coin.body, { x: -5, y: 0 });

  if (entities.obstacle.body.position.x < -entities.obstacle.size.width / 2) {
    dispatch({ type: 'score' });
    Matter.Body.setPosition(entities.obstacle.body, {
      x: width + entities.obstacle.size.width / 2,
      y: Math.random() * (height - 100) + 50,
    });
  }

  if (entities.coin.body.position.x < -entities.coin.size.width / 2) {
    Matter.Body.setPosition(entities.coin.body, {
      x: width + entities.coin.size.width / 2,
      y: Math.random() * (height - 100) + 50,
    });
  }

  return entities;
};
