import { useState } from 'react';

export const MoviePreview = (props) => {
    const [clicked, setClicked] = useState(false)

    const { movie, ...rest } = props

    return (
        <div
            className='movie'
            onClick={() => {
                setClicked(true)
            }}
            {...rest}
        >
            <button>{movie.title}</button>
        </div>
    )
}
