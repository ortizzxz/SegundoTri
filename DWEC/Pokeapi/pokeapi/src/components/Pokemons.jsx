import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

let url = "https://pokeapi.co/api/v2/pokemon/?offset=8&limit=8";

function Pokemons() {
  const [pokemonList, setPokemonList] = useState([]);
  const [loadingIndicator, setLoadingIndicator] = useState();

  useEffect(() => {
    loadPokemonData();
  }, []);

  function loadPokemonData() {
    setLoadingIndicator(
      <div className="d-flex justify-content-center align-items-center my-5">
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </div>
    );

    fetch(url)
      .then((response) => response.json())
      .then((pokemonData) => {
        const fetchDetailsPromises = pokemonData.results.map((pokemon) => {
          return fetch(pokemon.url)
            .then((response) => response.json())
            .then((pokemonDetails) => {
              return { ...pokemonDetails };
            });
        });

        Promise.all(fetchDetailsPromises).then((fetchedPokemonList) => {
          setLoadingIndicator(null); 
          setPokemonList((prevList) => [...prevList, ...fetchedPokemonList]);
          url = pokemonData.next; 
        });
      });
  }

  const pokemonCards = pokemonList.map((pokemon) => (
    <div
      key={pokemon.name}
      className="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center"
    >
      <div className="card shadow-sm border-2" style={{ width: "100%"}}>
        <div className="card-img-top text-center p-3">
          <Link to={`/detail/${pokemon.id}`}>
            <img
              src={pokemon.sprites.other["official-artwork"].front_default}
              alt={pokemon.name}
              className="img-fluid"
              style={{ width: "150px", height: "150px" }}
            />
          </Link>
        </div>
        <div className="card-body text-center">
          <span className="badge bg-primary text-uppercase">
            {pokemon.types[0].type.name}
          </span>
          <h5 className="card-title mt-2 text-capitalize">{pokemon.name}</h5>
          <Link
            to={`/detail/${pokemon.id}`}
            className="btn btn-outline-primary"
          >
            Ver Detalles{" "}
          </Link>
        </div>
      </div>
    </div>
  ));

  return (
    <>
      {/* Header */}
      <div className="page-header py-4 bg-light text-center">
        <div className="container">
          <h1 className="display-5">Explorador Pokemon</h1>
          <p className="lead">
            Descubre tu pokemon favorito y sus detalles.
          </p>
        </div>
      </div>

      {/* Pokemones */}
      <div className="section py-5">
        <div className="container">
          {/* posible search Bar? */}
          {/* <div className="row mb-4">
            <div className="col-md-8 mx-auto">
              <div className="input-group">
                <input
                  type="text"
                  className="form-control"
                  placeholder="Busca un Pokemon..."
                  aria-label="Busca un Pokémon"
                />
                <button className="btn btn-primary" type="button">
                  Search
                </button>
              </div>
            </div>
          </div> */}

          {/*  Cards */}
          <div className="row">
            {pokemonCards}
            {loadingIndicator}
          </div>

          {/* carga más */}
          <div className="row">
            <div className="col-12 text-center">
              <button
                onClick={loadPokemonData}
                className="btn btn-primary mt-4"
              >
                Cargar más
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default Pokemons;
