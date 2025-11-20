import React from 'react';
import { View } from 'react-native';
import Matter from 'matter-js';

const Coin = (props) => {
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
        backgroundColor: props.color || 'gold',
      }}
    />
  );
};

export default (world, label, color, pos, size) => {
  const initialCoin = Matter.Bodies.rectangle(
    pos.x,
    pos.y,
    size.width,
    size.height,
    { label, isStatic: true }
  );
  Matter.World.add(world, initialCoin);

  return {
    body: initialCoin,
    color,
    pos,
    size,
    renderer: <Coin />,
  };
};
