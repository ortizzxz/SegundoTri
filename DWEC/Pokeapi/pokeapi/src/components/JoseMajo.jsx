import { useState, useEffect } from "react";
import { Link } from "react-router-dom";

function JoseMajo() {
  const [listPetitions, setListPetitions] = useState([]);
  const URL = "https://jsonplaceholder.typicode.com/todos";
  var misResultados = [];

  useEffect(() => fetchAPI(), []);

  function fetchAPI() {
    fetch(URL)
      .then((res) => res.json())
      .then(
        (apiResponse) => {
          setListPetitions(apiResponse);
          console.log(listPetitions);
        },
        (error) => {
          console.log(error);
        }
      );
  }

  function ordenarResultados() {
    misResultados = listPetitions.slice(0, 10);
  }

  ordenarResultados();

  return (
    <>
      <ul>
        {misResultados.map((item, index) => (
          // eslint-disable-next-line react/jsx-key
          <Link to={`/defensa/${item.id}`}>
            <li key={index}>{item.title}</li>
        </Link>
        ))}
      </ul>
    </>
  );
}

export default JoseMajo;
