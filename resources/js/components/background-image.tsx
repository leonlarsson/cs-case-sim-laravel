export const BackgroundImage = () => (
    <img
        src={'/images/bg.jpg'}
        alt="Background image"
        width={1920}
        height={1080}
        style={{
            objectFit: 'cover',
            filter: 'brightness(0.8)',
            backgroundSize: 'cover',
            backgroundAttachment: 'fixed',
            backgroundPosition: 'center',
            backgroundRepeat: 'no-repeat',
            position: 'fixed',
            height: '100%',
            width: '100%',
            zIndex: -1,
        }}
    />
);
