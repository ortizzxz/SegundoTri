import { useState, useEffect } from "react";
import { db, auth } from "../firebase";
import { collection, doc, setDoc, getDoc } from "firebase/firestore";

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
                    <div className="section-heading">
                        <img className="img-fluid" src={solution.image} alt={solution.name} style={{ width: '300px', height: '300px', objectFit: 'contain' }} />
                    </div>
                    <div className="d-flex justify-content-center mt-3">
                        {pokemons.map((pokemon, index) => (
                            <button
                                onClick={() => handleOption(pokemon.name)}
                                key={index}
                                className="btn btn-outline-primary mx-2"
                                style={{
                                    fontSize: '18px',
                                    padding: '12px 24px',
                                    borderRadius: '8px',
                                    boxShadow: '0 4px 8px rgba(0, 0, 0, 0.1)',
                                    transition: 'background-color 0.3s, transform 0.3s'
                                }}
                            >
                                {pokemon.name}
                            </button>
                        ))}
                    </div>
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
            // Use callback to ensure the previous state is correctly used
            setPuntuation((prevPuntuation) => {
                const newPuntuation = prevPuntuation + 1;
                // If new score is higher than the best score, update it
                if (newPuntuation > bestPuntuation) {
                    setBestPuntuation(newPuntuation);
                    updateBestPuntuation(newPuntuation);
                }
                return newPuntuation;
            });
    
            setPokemonMaquetado(
                <div className="col-12 text-center">
                    <div className="section-heading">
                        <img className="img-fluid" src={solution.image} alt={solution.name} style={{ width: '300px', height: '300px', objectFit: 'contain' }} />
                    </div>
                    <div className="d-flex justify-content-center mt-3">
                        <h5 style={{ color: 'green', fontSize: '24px' }}>Correct!</h5><br /><br />
                    </div>
                    <div className="d-flex justify-content-center">
                        <button className="btn btn-success mx-2" style={{ fontSize: '18px', padding: '12px 24px', borderRadius: '8px' }}>
                            {solution.name}
                        </button>
                    </div>
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
                        <h5 style={{ color: 'red', fontSize: '24px' }}>Incorrect!</h5><br /><br />
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
                        <h2 style={{ color: 'red', fontSize: '36px', fontWeight: 'bold' }}>GAME OVER</h2><br /><br />
                        <button onClick={restartGame} className="btn btn-danger mx-2" style={{ fontSize: '18px', padding: '12px 24px', borderRadius: '8px' }}>
                            Restart
                        </button>
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
        <>
            <div className="section cta" style={{ background: '#f4f4f4', padding: '30px 0' }}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-5">
                            <div className="shop">
                                <div className="row">
                                    <div className="col-lg-12">
                                        <div className="section-heading">
                                            <h2 style={{ fontSize: '36px', color: '#333', fontWeight: 'bold' }}>¿Quién es ese pókemon?</h2>
                                        </div>
                                        <h5 style={{ fontSize: '20px', margin: '10px 0' }}>Tu puntuación: {puntuation}</h5>
                                        <h5 style={{ fontSize: '20px', margin: '10px 0' }}>Tu mejor puntuación: {bestPuntuation}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-5 offset-lg-2">
                            <div className="subscribe">
                                <div className="row">
                                    {pokemonMaquetado}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Game;
