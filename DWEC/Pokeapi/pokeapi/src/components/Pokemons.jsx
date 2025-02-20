import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

let url = "https://pokeapi.co/api/v2/pokemon/?offset=8&limit=9";

function Pokemons() {
  const [pokemonList, setPokemonList] = useState([]);
  const [loadingIndicator, setLoadingIndicator] = useState();
  const [searchTerm, setSearchTerm] = useState(""); // usuario input
  const [searchedPokemon, setSearchedPokemon] = useState(null); // pokemon buscado
  const [searchError, setSearchError] = useState(null); // error? sacado de internet lol

  useEffect(() => {
    loadPokemonData();
  }, []);

  function loadPokemonData() {
    setLoadingIndicator(
      <div className="d-flex justify-content-center align-items-center my-5">
        <div className="spinner-border custom-yellow-spinner" role="status">
          <span className="visually-hidden">Cargando...</span>
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

  function searchPokemon() {
    const query = searchTerm.trim().toLowerCase();

    //vacio borra busquedas y pone la lista nueva
    if (query === "") {
      loadPokemonData();
      setSearchedPokemon(null);
      setSearchError(null);
      return;
    }

    setLoadingIndicator(
      <div className="d-flex justify-content-center align-items-center my-3">
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Cargando...</span>
        </div>
      </div>
    );

    fetch(`https://pokeapi.co/api/v2/pokemon/${query}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Pokémon no encontrado");
        }
        return response.json();
      })
      .then((data) => {
        setPokemonList([]); //limpiar lista
        setSearchedPokemon(data);
        setSearchError(null);
        setLoadingIndicator(null);
      })
      .catch(() => {
        setSearchedPokemon(null); // no hay pokemon ?
        setSearchError("Pokémon no encontrado.");
        setLoadingIndicator(null);
      });
  }

  function deleteFilters() {
    setSearchTerm("");
    loadPokemonData();
    setSearchedPokemon(null);
    setSearchError(null);
  }

  const pokemonCards = pokemonList.map((pokemon) => (
    <div
      key={pokemon.name}
      className="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center"
    >
      <div className="card shadow-sm border-2" style={{ width: "100%" }}>
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
          <span className="badge bg-custom text-uppercase">
            {pokemon.types[0].type.name}
          </span>
          <h5 className="card-title mt-2 text-capitalize">{pokemon.name}</h5>
          <Link
            to={`/detail/${pokemon.id}`}
            className="btn btn-outline-primary custom-primary-btn"
          >
            Ver Detalles
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
          <h1 className="display-5">Explorador Pokémon</h1>
          <p className="lead">Descubre tu Pokémon favorito y sus detalles.</p>
        </div>
        <input
          className="px-2 py-1 border-custom border-input"
          type="text"
          name="pokemon"
          id="pokemon"
          placeholder="Busca un Pokémon..."
          value={searchTerm}
          onChange={(e) => setSearchTerm(e.target.value)} //termino de busqueda
          onKeyDown={(e) => {
            if (e.key === "Enter") {
              searchPokemon(); // con ( )
            }
          }}
        />
        <span
          className="p-2 mx-1 rounded custom-search"
          onClick={searchPokemon}
        >
          🔍
        </span>
        <span
          className="p-2 mx-1 rounded custom-search"
          onClick={deleteFilters}
        >
          ❌
        </span>
      </div>

      {/* Pokemones */}
      <div className="section py-5">
        <div className="container">
          {/*  Pokémon buscado */}
          {searchedPokemon && (
            <div className="row mb-4">
              <h3 className="text-center">Resultado de la búsqueda:</h3>
              <div className="col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                <div
                  className="card shadow-sm border-2"
                  style={{ width: "100%" }}
                >
                  <div className="card-img-top text-center p-3">
                    <Link to={`/detail/${searchedPokemon.id}`}>
                      <img
                        src={
                          searchedPokemon.sprites.other["official-artwork"]
                            .front_default
                        }
                        alt={searchedPokemon.name}
                        className="img-fluid"
                        style={{ width: "150px", height: "150px" }}
                      />
                    </Link>
                  </div>
                  <div className="card-body text-center">
                    <span className="badge bg-custom text-uppercase">
                      {searchedPokemon.types[0].type.name}
                    </span>
                    <h5 className="card-title mt-2 text-capitalize">
                      {searchedPokemon.name}
                    </h5>
                    <Link
                      to={`/detail/${searchedPokemon.id}`}
                      className="btn btn-outline-primary custom-primary-btn"
                    >
                      Ver Detalles
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* Error */}
          {searchError && (
            <p className="text-center text-danger">{searchError}</p>
          )}

          {/* Lista pokemon */}
          <div className="row">
            {pokemonCards}
            {loadingIndicator}
          </div>

          {/* cargar más */}
          <div className="row">
            <div className="col-12 text-center">
              <button onClick={loadPokemonData} className="btn custom-load-btn">
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
