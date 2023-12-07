import logo from './logo.svg';
import './App.css';
import { MoviePreview } from "./MoviePreview";
import { Fragment } from 'react';
import { useState } from 'react';


import { movies, noMovies } from './movies';

function App() {
  const [currentMovie, setCurrentMovie] = useState(null)

  console.log(currentMovie)

  return (
    <div>
      <p>My Movie App</p>

      <div className={'movieContainer'}>
      <button onClick={() => setCurrentMovie(null)}>Clear Movie</button>
        {
          movies.map((_movie, index) => {
            return (
              <MoviePreview
                movie={_movie}
                key={_movie.title}
                onClick={() => setCurrentMovie(_movie)}
              />
            )
          })
        }
      </div>

      <div className={'movieDisplay'}>
        {
          currentMovie ?
          //Fragment
            <>
              <p className={'movieTitleStyle'}>{currentMovie.title}</p>
              <img src={currentMovie.posterUrl} width={'200px'} alt={''} />
              <p>{currentMovie.description}</p>
              <p>Director: {currentMovie.director}</p>
              <p>Release Year: {currentMovie.releaseYear}</p>
              <p>Critic Rating: {currentMovie.rating}</p>
              <p className={'genreStyle'}>
              Genre: {currentMovie.categories.join(', ')}
            </p>
              
              
            </>
            :
            <p>No Movie Selected</p>
        }
      </div>
    </div>
  );
}

export default App;
