import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

function Defensa() {
  const { id } = useParams();
  const [nota, setNota] = useState(null);

  useEffect(() => {
    fetch(`https://jsonplaceholder.typicode.com/todos/${id}`)
      .then((response) => response.json())
      .then((data) => {
        setNota(data);
        console.log(data);
      })
      .catch((error) => {
        console.error("error fetching:", error);
      });
  }, [id]);



  if (!nota) {
    return (
      <div className="text-center mt-5">No se ha encontrado una nota</div>
    );
  }

  return (
      <>
            <div className="mb-4 align-items-center">
                <p>UserId: {nota.userId}</p>
                <p>Id: {nota.id}</p>
                <p>Titulo: {nota.title}</p>
            </div>
    </>
  );
}

export default Defensa;
