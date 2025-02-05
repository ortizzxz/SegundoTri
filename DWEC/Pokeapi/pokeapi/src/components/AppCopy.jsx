import "./App.css";
import { useState, useEffect } from "react";

function App() {
  const [error, setError] = useState(null);
  const [isLoaded, setIsLoaded] = useState(false);
  const [listPokemons, setListPokemons] = useState([]);
  const [nPokemons, setNPokemons] = useState(0);
  const [URL, setURL] = useState("https://pokeapi.co/api/v2/pokemon?limit=8");

  function fetchMore() {
    fetchPokemons();
  }
  
  useEffect(() => fetchPokemons(), []);

  function fetchPokemons() {
    fetch(URL)
      .then((res) => res.json()) // me llega la respuesta y la convierto a asincrono
      .then(
        (apiResponse) => {
          setIsLoaded(true);
          setNPokemons(apiResponse.count);
          setListPokemons(listPokemons.concat(apiResponse.results));
          setURL(apiResponse.next);
          // console.log(listPokemons);
          console.log(apiResponse);
        },
        (error) => {
          setIsLoaded(true);
          setError(error);
        }
      );
  }

  if (error) {
    return <div>Error: {error.message}</div>;
  } else if (!isLoaded) {
    return <div>Loading...</div>;
  } else {
    return (
      <>
        <h1>Número de Pokemons: {nPokemons}</h1>
        <ul>
          {listPokemons.map((item, index) => (
            <li key={index}>{item.name}</li>
          ))}
        </ul>
        <button onClick={fetchMore}>Cargar más Pokemons</button>
      </>
    );
  }
}

export default App;
