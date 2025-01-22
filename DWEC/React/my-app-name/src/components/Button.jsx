import PropTypes from 'prop-types';

function Button({ position }) {
    Button.propTypes = {
        position: PropTypes.string
    };

    function generateAlert() {
    alert("click button: " + position);
  }

  return (
    <>
      <div className="card">
        <button onClick={generateAlert}>Click</button>
      </div>
    </>
  );
}

export default Button;
