import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { Container, Row, Col, Button, ListGroup } from "react-bootstrap";

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
        console.error("error fetching:", error);
        setLoading(false);
      });
  }, [id]);

  if (loading) {
    return (
      <div
        className="d-flex justify-content-center align-items-center"
        style={{ height: "100vh" }}
      >
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Cargando...</span>
        </div>
      </div>
    );
  }

  if (!pokemon) {
    return (
      <div className="text-center mt-5">No se ha encontrado un Pokemon</div>
    );
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
              src={pokemon.sprites.other["official-artwork"].front_default} // la mejor que se ves
              alt={pokemon.name}
              className="img-fluid rounded yellow-shadow border border-1 border-secondary"
            />
          </Col>
          <Col lg={6}>
            <h2 className="text-uppercase py-4">{pokemon.name}</h2>

            {/* Tipo de pokemon */}
            <div className="mb-4 d-flex flex-wrap align-items-center">
                <p className="me-2 mb-0" style={{ fontSize: '18px', fontWeight: '600' }}>Tipo:</p>
                {pokemon.types.map((type, index) => (
                    <Button
                    key={index}
                    className="me-2 mb-2 custom-pointer"
                    >
                    {type.type.name.charAt(0).toUpperCase() + type.type.name.slice(1)}
                    </Button>
                ))}
            </div>


            <ListGroup variant="flush" className="mb-4"> 
              <ListGroup.Item>  {/* La altura está en 'd' así que hay que convertirla */}
                <strong>Altura:</strong> {(pokemon.height / 10).toFixed(1)} 
              </ListGroup.Item>
              <ListGroup.Item>
                <strong>Peso:</strong> {(pokemon.weight / 10).toFixed(1)} kg
              </ListGroup.Item>

              
              {pokemon.abilities.map((ability, index) => ( // Habialidad del pokemons (i + 1)
                <ListGroup.Item key={index}>
                  <strong>Habilidad {index + 1}:</strong> {ability.ability.name} 
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
