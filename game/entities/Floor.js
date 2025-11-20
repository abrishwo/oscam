import React from 'react';
import { View } from 'react-native';
import Matter from 'matter-js';

const Floor = (props) => {
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
        backgroundColor: props.color || 'green',
      }}
    />
  );
};

export default (world, color, pos, size) => {
  const initialFloor = Matter.Bodies.rectangle(
    pos.x,
    pos.y,
    size.width,
    size.height,
    { label: 'Floor', isStatic: true }
  );
  Matter.World.add(world, initialFloor);

  return {
    body: initialFloor,
    color,
    pos,
    size,
    renderer: Floor,
  };
};
