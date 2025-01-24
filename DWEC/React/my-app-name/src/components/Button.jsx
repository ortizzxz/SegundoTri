import PropTypes from "prop-types";
import { useState } from "react";

function Button({ position }) {
  const [count, setCount] = useState(0);

  Button.propTypes = {
    position: PropTypes.string,
  };

  function generateAlert() {
    console.log("Position: " + position);
  }

  function handleClick() {
    generateAlert();
    setCount((prevCount) => prevCount + 1);
  }

  return (
    <>
      <div className="card">
        <button onClick={handleClick}>Click {count}</button> 
      </div>
    </>
  );
}

export default Button; // No se puede llamar a dos eventos en un mismo OnClick
