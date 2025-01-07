import { Button, Card, Grid, Heading } from '@/components/ui';
import GameScreen from '@/layouts/game-screen';
import {router, usePage} from '@inertiajs/react';

export default function map() {
    // @ts-ignore
    const character = usePage().props.auth.character.data;

    function moveToQuestsTab(questId) {
        router.get(route('games.participate.id', questId));
    }

    return (
        <GameScreen>
            {character.quests.length === 0 && (
                <>
                <Heading level={3}>
                    Aktualnie nie masz żadnych misji w swoim dzienniczku, zmień to odwiedzając tablicę zadań w ekranie głównym!
                </Heading>
                <p className={"text-gray-500"}> Pamiętaj że misje przynoszą bogactwo!</p>
                </>
            )}
            {character.quests.length > 0 && (
                <>
                    <h1 className={'mt-8 text-2xl font-semibold'}>
                        Aktualne misje
                    </h1>
                    <div className={'mt-4'}>
                        <Grid columns={6} className={'gap-4'}>
                            {character.quests.map((quest) => (
                                <Grid.Item
                                    className={''}
                                    key={'mission' + quest.id}
                                >
                                    <Card className="flex h-full flex-col justify-between">
                                        <Card.Header>
                                            <Card.Title>
                                                {quest.id} - {quest.name}
                                            </Card.Title>
                                        </Card.Header>
                                        <Card.Content>
                                            {quest.description}

                                            {quest.rewards.length > 0 && (
                                                <div className={'mt-4'}>
                                                    Nagroda:
                                                </div>
                                            )}
                                            {quest.rewards.map((reward) => (
                                            <div key={reward.id}>
                                                {reward.resourceName}{' '}
                                                {reward.statisticName}{' '}
                                                {reward.buildingName} x{' '}
                                                {reward.value}
                                            </div>
                                        ))}
                                        </Card.Content>
                                        <Card.Footer className={''}>
                                            {quest.type !== 'Porozmawiaj' && (
                                                <Button
                                                    appearance={'outline'}
                                                    onClick={() =>
                                                        moveToQuestsTab(
                                                            quest.id,
                                                        )
                                                    } // Use an arrow function here
                                                >
                                                    Przejdź do misji
                                                </Button>
                                            )}
                                        </Card.Footer>
                                    </Card>
                                </Grid.Item>
                            ))}
                        </Grid>
                    </div>
                </>
            )}

            {character.quests_completed.length > 0 && (
                <>
                    <h1 className={'mt-8 text-2xl font-semibold'}>
                        Skończone misje
                    </h1>
                    <div className={'mt-4'}>
                        <Grid columns={6} className={'gap-4'}>
                            {character.quests_completed.map((quest) => (
                                <Grid.Item
                                    className={''}
                                    key={'mission' + quest.id}
                                >
                                    <Card className="h-full">
                                        <Card.Header>
                                            <Card.Title>
                                                {quest.id} - {quest.name}
                                            </Card.Title>
                                        </Card.Header>
                                        <Card.Content>
                                            {quest.description}
                                        </Card.Content>
                                    </Card>
                                </Grid.Item>
                            ))}
                        </Grid>
                    </div>
                </>
            )}
        </GameScreen>
    );
}
