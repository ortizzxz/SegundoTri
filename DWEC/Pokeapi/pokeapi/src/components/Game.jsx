import { useState, useEffect } from "react";
import { db, auth } from "../firebase";
import { collection, doc, setDoc, getDoc, getDocs } from "firebase/firestore";

function Leaderboard() {
  const [leaderboard, setLeaderboard] = useState([]);

  useEffect(() => {
      loadLeaderboard();
  }, []);

  function loadLeaderboard() {
      const pokeapiDB = collection(db, "pokeapi");

      getDocs(pokeapiDB).then((snapshot) => {
          const leaderboardData = snapshot.docs.map(doc => ({
              id: doc.id,
              ...doc.data(),
          }));

          leaderboardData.sort((a, b) => b.puntuation - a.puntuation);

          setLeaderboard(leaderboardData.slice(0, 5));
      }).catch((error) => {
          console.error("Error fetching leaderboard data:", error);
      });
  }

  return (
      <div className="leaderboard-section bg-gradient p-4 rounded-lg shadow">
          <h3 className="text-center custom-title font-weight-bold">Leaderboard</h3>
          <ul className="list-group leaderboard-list">
              {leaderboard.map((player, index) => (
                  <li key={player.id} className="list-group-item d-flex justify-content-between align-items-center leaderboard-item">
                      <span className="rank-number">{index + 1}.</span>
                      <div className="player-info">
                          <span className="player-name">{player.name}</span>
                          <span className="player-points">{player.puntuation} points</span>
                      </div>
                  </li>
              ))}
          </ul>

          {/* Custom styles */}
          <style>
              {`
                  .leaderboard-section {
                      margin-top: 1rem;
                      border-radius: 10px;
                      padding: 20px;
                  }

                  .leaderboard-list {
                      margin-top: 20px;
                      border-radius: 8px;
                      padding: 0;
                      overflow-y: auto;
                  }

                  .leaderboard-item {
                      background-color: #ffffff;
                      border-radius: 8px;
                      padding: 12px 18px;
                      margin-bottom: 12px;
                      font-size: 18px;
                      font-weight: 500;
                      transition: background-color 0.3s ease;
                      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                  }

                  .leaderboard-item:hover {
                      background-color: #f1f1f1;
                      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
                  }

                  .custom-title{
                    color: black;
                  }

                  .rank-number {
                      font-size: 24px;
                      font-weight: bold;
                      color: #FFC300;
                  }

                  .player-info {
                      display: flex;
                      flex-direction: column;
                      align-items: flex-start;
                  }

                  .player-name {
                      font-size: 18px;
                      font-weight: 600;
                      color: #333;
                  }

                  .player-points {
                      font-size: 18px;
                      font-weight: 400;
                      color: #FFC300;
                  }
              `}
          </style>
      </div>
  );
}


function Game() {
    let [pokemonMaquetado, setPokemonMaquetado] = useState();
    let [puntuation, setPuntuation] = useState(0);
    let [bestPuntuation, setBestPuntuation] = useState(0);
    let solution;

    useEffect(() => {
        initGame();
        loadBestPuntuation();
    }, []);

    function loadBestPuntuation() {
        const user = auth.currentUser;
        if (user) {
            const userId = user.uid;
            const userRef = doc(db, "pokeapi", userId);

            getDoc(userRef).then((snapshot) => {
                if (snapshot.exists()) {
                    setBestPuntuation(snapshot.data().puntuation);
                } else {
                    setBestPuntuation(0);
                }
            }).catch((error) => {
                console.error("Error fetching best puntuations:", error);
            });
        }
    }

    function initGame() {
        cargarPokemons().then((pokemons) => {
            solution = pokemons[Math.floor(Math.random() * pokemons.length)];

            setPokemonMaquetado(
                <div className="col-12 text-center">
                  {/* Image */}
                  <div className="section-heading">
                    <img
                      className="img-fluid"
                      src={solution.image}
                      alt={solution.name}
                      style={{
                        width: "300px",
                        height: "300px",
                        objectFit: "contain",
                        filter: "blur(0.5rem)"
                      }}
                    />
                  </div>
              
                  {/* Buttons */}
                  <div className="d-flex flex-wrap justify-content-center mt-4">
                    {pokemons.map((pokemon, index) => (
                      <button
                        onClick={() => handleOption(pokemon.name)}
                        key={index}
                        className="btn pokemon-btn mx-2 my-2"
                      >
                        {pokemon.name}
                      </button>
                    ))}
                  </div>

                  <style>
                    {`
                      .pokemon-btn {
                        font-size: 18px;
                        padding: 12px 24px;
                        border-radius: 8px;
                        border: 2px solid #FFC300;
                        background: linear-gradient(45deg, #FFD92A, #FFC300, #FFB700);
                        color: #222;
                        font-weight: bold;
                        transition: all 0.3s ease-in-out;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                      }
              
                      .pokemon-btn:hover {
                        transform: translateY(-3px);
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                        background: linear-gradient(45deg, #FFB700, #FFC300, #FFD92A);
                      }
              
                      .pokemon-btn:active {
                        transform: translateY(1px);
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                      }
                    `}
                  </style>
                </div>
            );
        });
    }

    function restartGame() {
        setPuntuation(0);
        initGame();
    }

    async function cargarPokemons() {
        let pokemons = [];
        let fetchPromises = [];

        for (let i = 0; i < 3; i++) {
            let randomPokemonId = Math.floor(Math.random() * 898) + 1;
            let fetchPromise = fetch("https://pokeapi.co/api/v2/pokemon/" + randomPokemonId)
                .then((response) => response.json())
                .then((pokemon) => {
                    let pokemonData = {
                        name: pokemon.name,
                        image: pokemon.sprites.other['showdown'].front_default
                    };
                    return pokemonData;
                });

            fetchPromises.push(fetchPromise);
        }

        await Promise.all(fetchPromises)
            .then((results) => {
                pokemons = results;
            });

        return pokemons;
    }

    function handleOption(namePokemon) {
        if (namePokemon === solution.name) {
            setPuntuation((prevPuntuation) => {
                const newPuntuation = prevPuntuation + 1;
                if (newPuntuation > bestPuntuation) {
                    setBestPuntuation(newPuntuation);
                    updateBestPuntuation(newPuntuation);
                }
                return newPuntuation;
            });
    
            setPokemonMaquetado(
                <div className="col-12 text-center">
                  {/* Pokémon Image */}
                  <div className="section-heading">
                    <img
                      className="img-fluid"
                      src={solution.image}
                      alt={solution.name}
                      style={{
                        width: "300px",
                        height: "300px",
                        objectFit: "contain",
                      }}
                    />
                  </div>
              
                  {/* Correct Message */}
                  <div className="d-flex justify-content-center mt-3">
                    <h5 className="correct-text">¡Correcto!</h5>
                  </div>
              
                  {/* Correct Answer Button */}
                  <div className="d-flex justify-content-center">
                    <button className="btn correct-btn mx-2">{solution.name}</button>
                  </div>

                  {/* Custom Styles */}
                  <style>
                    {`
                      .correct-text {
                        color: #28a745;
                        font-size: 24px;
                        font-weight: bold;
                        animation: fadeIn 0.5s ease-in-out;
                      }
              
                      .correct-btn {
                        font-size: 18px;
                        padding: 12px 24px;
                        border-radius: 8px;
                        background: linear-gradient(45deg, #28a745, #34d058);
                        color: white;
                        font-weight: bold;
                        border: none;
                        transition: all 0.3s ease-in-out;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                      }
              
                      .correct-btn:hover {
                        transform: translateY(-3px);
                        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                        background: linear-gradient(45deg, #34d058, #28a745);
                      }
              
                      .correct-btn:active {
                        transform: translateY(1px);
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                      }
              
                      @keyframes fadeIn {
                        from {
                          opacity: 0;
                          transform: scale(0.9);
                        }
                        to {
                          opacity: 1;
                          transform: scale(1);
                        }
                      }
                    `}
                  </style>
                </div>
            );
    
            setTimeout(() => {
                initGame();
            }, 2000);
        } else {
            if (puntuation > bestPuntuation) {
                updateBestPuntuation(puntuation);
            }
    
            setPokemonMaquetado(
                <div className="col-12 text-center">
                    <div className="section-heading">
                        <img className="img-fluid" src={solution.image} alt={solution.name} style={{ width: '300px', height: '300px', objectFit: 'contain' }} />
                    </div>
                    <div className="d-flex justify-content-center mt-3">
                        <h5 style={{ color: 'red', fontSize: '24px' }}>¡Incorrecto!</h5><br /><br />
                    </div>
                    <div className="d-flex justify-content-center">
                        <button className="btn btn-danger mx-2" style={{ fontSize: '18px', padding: '12px 24px', borderRadius: '8px' }}>
                            {solution.name}
                        </button>
                    </div>
                </div>
            );
    
            setTimeout(() => {
                setPokemonMaquetado(
                    <div className="col-12 text-center">
                      {/* Game Over  */}
                      <h2 className="game-over-text">Has perdido</h2>
              
                      {/* Restart  */}
                      <button onClick={restartGame} className="btn restart-btn mx-2">
                        Restart
                      </button>

                      <style>
                        {`
                          .game-over-text {
                            color: red;
                            font-size: 36px;
                            font-weight: bold;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            animation: fadeIn 0.8s ease-in-out;
                          }
                  
                          .restart-btn {
                            font-size: 18px;
                            padding: 12px 24px;
                            border-radius: 8px;
                            background: linear-gradient(45deg, #dc3545, #ff0000);
                            color: white;
                            font-weight: bold;
                            border: none;
                            transition: all 0.3s ease-in-out;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                          }
                  
                          .restart-btn:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                            background: linear-gradient(45deg, #ff0000, #dc3545);
                          }
                  
                          .restart-btn:active {
                            transform: translateY(1px);
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                          }
                  
                          @keyframes fadeIn {
                            from {
                              opacity: 0;
                              transform: scale(0.9);
                            }
                            to {
                              opacity: 1;
                              transform: scale(1);
                            }
                          }
                        `}
                      </style>

                    </div>
                );
            }, 2000);
        }
    }
    
    function updateBestPuntuation(newPuntuation) {
        const user = auth.currentUser;
        if (user) {
            const uid = user.uid;
            const displayName = user.displayName;
            const photoURL = user.photoURL;
            const pokeapiDB = collection(db, "pokeapi");
            const puntuationRef = doc(pokeapiDB, uid);

            setDoc(puntuationRef, { uid: uid, name: displayName, photoURL: photoURL, puntuation: newPuntuation }, { merge: true })
                .then(() => {
                    loadBestPuntuation();
                })
                .catch((error) => {
                    console.error("Error updating best puntuations:", error);
                });
        }
    }

    return (
        <div className="section cta game-section text-white">
            <div className="container">
                <div className="row align-items-center">
                    {/* Left Section */}
                    <div className="col-lg-5">
                        <div className="shop bg-light p-4 rounded shadow border-custom">
                            <div className="section-heading">
                                <h2 className="game-title text-center">¿Quién es ese Pokémon?</h2>
                            </div>
                            <h5 className="score-text text-center">Tu puntuación: <span className="fw-bold">{puntuation}</span></h5>
                            <h5 className="score-text text-center">Tu mejor puntuación: <span className="fw-bold">{bestPuntuation}</span></h5>
                        </div>
                    </div>
        
                    {/* Right Section */}
                    <div className="col-lg-5 offset-lg-2">
                        <div className="subscribe p-4 bg-light rounded shadow border-custom">
                            <div className="row">{pokemonMaquetado}</div>
                        </div>
                    </div>
                </div>

                {/* Leaderboard Section */}
                <div className="row">
                    <div className="col-12">
                        <Leaderboard />
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Game;
