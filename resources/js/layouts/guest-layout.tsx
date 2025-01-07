import GameBanner from '@/components/shared/game-banner';
import {Container} from '@/components/ui';
import { PropsWithChildren } from 'react';

interface GuestProps extends PropsWithChildren {
    className?: string;
}

export default function Guest({children, className}: GuestProps) {
    return (
        <Container intent="padded-content">
            <GameBanner/>
            <div className={className}>{children}</div>
        </Container>
    );
}
