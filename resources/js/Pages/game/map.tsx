import {buttonStyles, Card, Grid, Heading, Link} from '@/components/ui';
import GameScreen from '@/layouts/game-screen';
import useGameStore from '@/store/gameStore';

export default function map() {
    const {localizations} = useGameStore((state) => state);
    console.log(localizations);
    return (
        <GameScreen>
            {/*  Musimy wylistować wszystkie lokacje, dać możliwość użytkownikowi poruszać się w ich stronę oraz jeżeli w lokalizacji jest quest to pokażmy !   */}

            <Heading className={'pt-4'}> Witaj na mapie </Heading>
            <p>
                {' '}
                Tutaj możesz przemieszczać się do interesujących Cię miejsc w
                świecie gry - te z żółtym pytajnikiem powinny być dla Ciebie
                najbardziej interesujace
            </p>

            <Grid columns={5} className={'mt-4 gap-4'}>
                {localizations.map((localization) => (
                    <Grid.Item key={localization.id}>
                        <Card className="max-w-lg">
                            <Card.Header>
                                <Card.Title>
                                    {' '}
                                    {localization.quests_available.length >
                                        0 && (
                                            <span className={'text-yellow-500'}>
                                            {' '}
                                                !
                                        </span>
                                        )}{' '}
                                    {localization.name}
                                </Card.Title>
                            </Card.Header>
                            <Card.Content className={'text-sm text-gray-500'}>
                                {localization.description}
                            </Card.Content>
                            <Card.Footer>
                                <Link
                                    className={buttonStyles({
                                        appearance: 'outline',
                                    })}
                                    href={route('change.localization', [
                                        localization.id,
                                    ])}
                                >
                                    {' '}
                                    Przejdź do lokalizacji
                                </Link>
                            </Card.Footer>
                        </Card>
                    </Grid.Item>
                ))}
            </Grid>
        </GameScreen>
    );
}
