import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { Container, Row, Col, Button, ListGroup } from 'react-bootstrap';

function Detail() {
    const { id } = useParams();
    const [pokemon, setPokemon] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch(`https://pokeapi.co/api/v2/pokemon/${id}/`)
            .then((response) => response.json())
            .then((data) => {
                setPokemon(data);
                setLoading(false);
            })
            .catch((error) => {
                console.error("Error fetching Pokemon data:", error);
                setLoading(false);
            });
    }, [id]);

    if (loading) {
        return (
            <div className="d-flex justify-content-center align-items-center" style={{ height: "100vh" }}>
                <div className="spinner-border text-primary" role="status">
                    <span className="visually-hidden">Cargando...</span>
                </div>
            </div>
        );
    }

    if (!pokemon) {
        return <div className="text-center mt-5">No se ha encontrado un Pokemon</div>;
    }

    return (
        <>
            <Container fluid className="bg-light py-2">
                <Row>
                    <Col lg={12} className="text-center">
                        <h1 className="display-6">Características del Pokemon</h1>
                    </Col>
                </Row>
            </Container>

            <Container className="mb-2">
                <Row>
                    <Col lg={4} className="mb-lg-0 p-4">
                        <img 
                            src={pokemon.sprites.other['official-artwork'].front_default} 
                            alt={pokemon.name} 
                            className="img-fluid rounded shadow border border-1 border-secondary"
                        />
                    </Col>
                    <Col lg={6}>
                        <h2 className="text-uppercase py-4">{pokemon.name}</h2>
                        <p className="h4 text-muted mb-2">ID: {pokemon.id}</p>

                        <div className="mb-4">
                            {pokemon.types.map((type, index) => (
                                <Button key={index} variant="outline-primary" className="me-2 mb-2">
                                    {type.type.name}
                                </Button>
                            ))}
                        </div>

                        <ListGroup variant="flush" className="mb-4">
                            <ListGroup.Item><strong>Height:</strong> {pokemon.height}</ListGroup.Item>
                            <ListGroup.Item><strong>Weight:</strong> {pokemon.weight}</ListGroup.Item>
                            <ListGroup.Item>
                                <strong>Moves:</strong> {pokemon.moves.map(move => move.move.name).join(', ')}
                            </ListGroup.Item>
                            {pokemon.abilities.map((ability, index) => (
                                <ListGroup.Item key={index}>
                                    <strong>Ability {index + 1}:</strong> {ability.ability.name}
                                </ListGroup.Item>
                            ))}
                        </ListGroup>

                    </Col>
                </Row>
            </Container>
        </>
    );
}

export default Detail;
