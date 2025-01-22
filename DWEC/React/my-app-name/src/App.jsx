import './App.css'
import Button from './components/Button';

function App() {
  const buttonData = ['Button 1', 'Button 2', 'Button 3'];
  return (
    <div>
      {buttonData.map((_, index) => (
        <Button key={index} position={index + 1} />
      ))}
    </div>
  )
}

export default App
