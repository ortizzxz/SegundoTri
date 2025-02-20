import { Link } from "react-router-dom";
import JoseMajo from './JoseMajo';

function Home() {
  return (
    <div className="container mt-5">
      <div>
        {/*DEFENDA JOSE */}
        <JoseMajo></JoseMajo>
      </div>
      {/* Header */}
      <div className="jumbotron bg-light text-center p-5 rounded border-custom">
        <h1 className="display-4">¡Bienvenido al Explorador PokeAPI!</h1>
        <p className="lead">
            Descubre el fascinante mundo de Pokemon utilizando la PokeAPI. Busca pokemones, explora sus habilidades, y pon a prueba tu conocimiento con divertidos juegos.
        </p>
        <hr className="my-4" />
        <p>
          ¿Listo para explorar? - Haz click debajo para empezar tu aventura Pokemon.
        </p>
        <Link to="/pokemons" className="btn  btn-lg custom-primary-btn">
          Explora Pokemones
        </Link>
      </div>

      {/* caracteristicas de la app */}
      <div className="row mt-5">
        {/* feature 1 */}
        <div className="col-md-4 text-center">
          <img
            src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png"
            alt="Pikachu"
            className="img-fluid mb-3"
            style={{ width: "150px" }}
          />
          <h3>Descubre Pokemones</h3>
          <p>
            Navega a través de una colección de más de 13k pokemones y aprende acerca de sus habiliades, estadisticas, tipos y más.
          </p>
        </div>

        {/* feture 2 */}
        <div className="col-md-4 text-center">
          <img
            src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png"
            alt="Charizard"
            className="img-fluid mb-3"
            style={{ width: "150px" }}
          />
          <h3>¡Juega!</h3>
          <p>
            Pon a prueba tu conocimiento con juegos interactivos y retos. ¿A cuantos puedes reconocer?
          </p>
        </div>

        {/* feat 3 */}
        <div className="col-md-4 text-center">
          <img
            src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/150.png"
            alt="Mewtwo"
            className="img-fluid mb-3"
            style={{ width: "150px" }}
          />
          <h3>Unete a la comunidad</h3>
          <p>
            Comparte tu conocimiento Pokemon con otros fans del universo Pokemon.
          </p>
        </div>
      </div>

      {/* Footer Section */}
      <footer className="text-center mt-5">
        <p className="text-muted">
          
          Hecho con ❤️ por alumnos de CFGS - DAW |
          Visita mi{" "}
          <a href="" target="_blank" rel="noopener noreferrer">
            GitHub
          </a>
        </p>
      </footer>
    </div>
  );
}

export default Home;
