import React from 'react';
import { View } from 'react-native';
import Matter from 'matter-js';

const Player = (props) => {
  const width = props.size.width;
  const height = props.size.height;
  const x = props.body.position.x - width / 2;
  const y = props.body.position.y - height / 2;

  return (
    <View
      style={{
        position: 'absolute',
        left: x,
        top: y,
        width: width,
        height: height,
        backgroundColor: props.color || 'pink',
      }}
    />
  );
};

export default (world, color, pos, size) => {
  const initialPlayer = Matter.Bodies.rectangle(
    pos.x,
    pos.y,
    size.width,
    size.height,
    { label: 'Player' }
  );
  Matter.World.add(world, initialPlayer);

  return {
    body: initialPlayer,
    color,
    pos,
    size,
    renderer: Player,
  };
};
