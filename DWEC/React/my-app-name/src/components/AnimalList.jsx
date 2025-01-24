
const AnimalList = ({ animals }) => {
  return (
    <div className="animal-list">
      {animals.map((animal, index) => (
        <div key={index} className="animal-item">
          {animal}
        </div>
      ))}
    </div>
  );
};
    
export default AnimalList;
