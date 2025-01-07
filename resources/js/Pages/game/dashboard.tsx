import MissionBoard from '@/components/game/mission-board';
import PeopleBoard from '@/components/game/people-board';
import {Card, Grid, Heading, Tabs} from '@/components/ui';
import GameScreen from '@/layouts/game-screen';
import {usePage} from '@inertiajs/react';

export default function gameDashboard() {
    const {auth} = usePage().props;
    // @ts-ignore
    const character = auth.character.data;

    return (
        <GameScreen>
            <div className={'pt-8'}>
                <Heading className={'text-2xl font-semibold'}>
                    Witaj {character.name}
                </Heading>
                <p>
                    {' '}
                    Aktualnie przebywasz w:
                    {character.localization
                        ? ' ' + character.localization
                        : ' obozie'}
                </p>
                <p className={'text-gray-500'}>Oto twoje statystyki</p>
                <div className={'mt-4'}>
                    <Grid columns={6} className={'gap-4'}>
                        {character.statistics.map((statistic) => (
                            <Grid.Item key={statistic.id}>
                                <Card className="h-full">
                                    <Card.Header>
                                        <Card.Title>
                                            {statistic.statistic_name}
                                        </Card.Title>
                                    </Card.Header>
                                    <Card.Content>
                                        Punkty: {statistic.statistic_value}
                                    </Card.Content>
                                </Card>
                            </Grid.Item>
                        ))}
                    </Grid>
                </div>
                <Tabs aria-label="Lokalizacja" className={'mt-16'}>
                    <Tabs.List>
                        <Tabs.Tab id="r">Tablica misji</Tabs.Tab>
                        <Tabs.Tab id="i">Osoby w obszarze</Tabs.Tab>
                    </Tabs.List>
                    <Tabs.Panel id="r">
                        <MissionBoard/>
                    </Tabs.Panel>
                    <Tabs.Panel id="i">
                        <PeopleBoard/>
                    </Tabs.Panel>
                </Tabs>
            </div>
        </GameScreen>
    );
}
