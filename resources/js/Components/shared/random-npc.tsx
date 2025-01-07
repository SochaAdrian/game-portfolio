import {useTheme} from '@/components/theme-provider';

const colorMapping = {
    skin_colors: {
        light: '#FFDBAC',
        tan: '#F1C27D',
        brown: '#C68642',
        dark: '#8D5524',
        black: '#1C1C1C', // Black skin color hex value
    },
    hair_colors: {
        blonde: '#F7E8B5',
        brown: '#7B4F36',
        black: '#2F2F2F',
        red: '#B55239',
        gray: '#BEBEBE',
        white: '#FFFFFF',
    },
};

const RandomNpc = ({appearance}) => {
    const {theme} = useTheme();
    const {gender, skin_color, hair_color, face_expression} = appearance;

    const mappedskin_color = colorMapping.skin_colors[skin_color] || '#FFDBAC';
    const mappedhair_color = colorMapping.hair_colors[hair_color] || '#7B4F36';

    // Use red stroke for face and eyes if skin_color is black
    const strokeColor =
        skin_color === 'black' ? 'red' : theme === 'dark' ? 'white' : 'black';

    return (
        <svg
            width="200"
            height="300"
            viewBox="0 0 200 300"
            xmlns="http://www.w3.org/2000/svg"
        >
            {/* Body */}
            <line
                x1="100"
                y1="120"
                x2="100"
                y2="280"
                stroke={strokeColor}
                strokeWidth="2"
            />

            {/* Head */}
            <circle
                cx="100"
                cy="70"
                r="50"
                fill={mappedskin_color}
                stroke={strokeColor}
                strokeWidth="2"
            />

            {/* Hair */}
            {gender === 'man' ? (
                <path
                    d="M50,50 Q100,0 150,50 Q120,20 80,20 Z"
                    fill={mappedhair_color}
                />
            ) : (
                <path
                    d="M40,60 Q100,-10 160,60 Q120,-20 80,-20 Z"
                    fill={mappedhair_color}
                />
            )}

            {/* Eyes */}
            <circle cx="80" cy="70" r="5" fill={strokeColor}/>
            <circle cx="120" cy="70" r="5" fill={strokeColor}/>

            {/* Eyebrows */}
            {face_expression === 'angry' ? (
                <>
                    <line
                        x1="70"
                        y1="60"
                        x2="90"
                        y2="65"
                        stroke={strokeColor}
                        strokeWidth="2"
                    />
                    <line
                        x1="110"
                        y1="65"
                        x2="130"
                        y2="60"
                        stroke={strokeColor}
                        strokeWidth="2"
                    />
                </>
            ) : (
                <>
                    <line
                        x1="70"
                        y1="60"
                        x2="90"
                        y2="60"
                        stroke={strokeColor}
                        strokeWidth="2"
                    />
                    <line
                        x1="110"
                        y1="60"
                        x2="130"
                        y2="60"
                        stroke={strokeColor}
                        strokeWidth="2"
                    />
                </>
            )}

            {/* Mouth */}
            {face_expression === 'happy' && (
                <path
                    d="M70,90 Q100,120 130,90"
                    stroke={strokeColor}
                    strokeWidth="2"
                    fill="transparent"
                />
            )}
            {face_expression === 'sad' && (
                <path
                    d="M70,120 Q100,90 130,120"
                    stroke={strokeColor}
                    strokeWidth="2"
                    fill="transparent"
                />
            )}
            {face_expression === 'neutral' && (
                <line
                    x1="70"
                    y1="100"
                    x2="130"
                    y2="100"
                    stroke={strokeColor}
                    strokeWidth="2"
                />
            )}
            {face_expression === 'angry' && (
                <>
                    <path
                        d="M70,120 Q100,90 130,120"
                        stroke={strokeColor}
                        strokeWidth="2"
                        fill="transparent"
                    />
                </>
            )}
        </svg>
    );
};

export default RandomNpc;
