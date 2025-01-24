import "./App.css";
import AnimalList from "./components/AnimalList";
import Button from "./components/Button";
import  { RenderJSON } from "./components/RenderJSON"

function App() {
  const buttonData = ["Ana", "Belén", "Carlos"];

  const animals = [
    "Iguana",
    "Lagarto",
    "Crocodilo",
    "Pejelagarto",
    "Doonkey Kong",
    "Godzilla",
  ];

  var iterateOnArray = buttonData.map((data, index) => (
    <li key={index}> {data} </li>
  ));

  function greetMe(event, formData) {
    event.preventDefault();
    const name = formData.get("name");
    alert(`Holaaaa '${name}'`);
  }

  var bromas = [
    {
      id: 1,
      setup: "What's the best thing about a Boolean?",
      punchline: "Even if you're wrong, you're only off by a bit"
    },
    {
      id: 2,
      setup: "Why do programmers wear glasses?",
      punchline: "Because they need to C#"
    }
  ];

  return (
    <>
      {/* Lista de Botones */}

      <div>
        {buttonData.map((_, index) => (
          <Button key={index} position={index + 1} />
        ))}
      </div>

      {/* Lista de nombres */}
      <div>
        <ol>{iterateOnArray}</ol>
      </div>

      {/* Lista de animales */}
      <div>
        <AnimalList animals={animals} />
      </div>

      {/* Formulario */}
      <form onSubmit={(event) => greetMe(event, new FormData(event.target))}>
        <h3>Saludame porfis</h3>
        <input name="name" />
        <button type="submit">Saludame</button>
      </form>

      {/* Lista de json */}
        <div id="bromas">
          {bromas.map((broma) => {
            return <RenderJSON key={broma.id} setup={broma.setup} punchline={broma.punchline} />
          })}
        </div>
    </>
  );
}

export default App;
