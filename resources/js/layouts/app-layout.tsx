import { BackgroundImage } from '@/components/background-image';
import AudioProvider from '@/components/providers/audio-provider';
import { Head } from '@inertiajs/react';

type AppLayoutProps = {
    children: React.ReactNode;
};

export default ({ children }: AppLayoutProps) => (
    <div>
        <Head>
            <link rel="shortcut icon" href="/images/favicon.png" type="image/png-icon" />
        </Head>
        <BackgroundImage />
        <AudioProvider>{children}</AudioProvider>
    </div>
);
