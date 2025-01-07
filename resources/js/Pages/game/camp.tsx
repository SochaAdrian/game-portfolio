import {Button, Card, Grid} from '@/components/ui';
import GameScreen from '@/layouts/game-screen';
import useResourceStore from '@/store/resourceStore';
import {usePage} from '@inertiajs/react';
import axios from 'axios';
import {useState} from 'react';

export default function camp() {
    const {auth} = usePage().props;
    // @ts-ignore
    const character = auth.character.data;

    const { resources, incrementProgress, updateResource } = useResourceStore();
    const [flyingBonus, setFlyingBonus] = useState<Record<number, boolean>>({}); // Track flying state per resource

    const handleResourceClick = (resource: { id: number; name: string }) => {
        incrementProgress(resource.id);

        const resourceProgress =
            resources.find((r) => r.id === resource.id)?.progress || 0;

        if (resourceProgress + 1 >= 10) {
            axios
                .post(route('resources.increment', [resource.id]))
                .then((response) => {
                    updateResource(resource.id, response.data.newValue);

                    setFlyingBonus((prev) => ({
                        ...prev,
                        [resource.id]: true,
                    }));
                    setTimeout(() => {
                        setFlyingBonus((prev) => ({
                            ...prev,
                            [resource.id]: false,
                        }));
                    }, 700);
                })
                .catch((error) => {
                    console.error('Failed to update resource:', error);
                });
        }
    };

    return (
        <GameScreen>
            <div className="pt-8">
                <h1 className="text-2xl font-semibold">Obóz</h1>
                <p className="text-gray-500">
                    Witaj w swoim obozie - tutaj bedziesz mogl wykonywać pewne
                    akcje jak kupowanie budynków czy wydobywanie zasobów
                </p>

                <div className="mt-4">
                    <Grid columns={6} className="gap-4">
                        {resources.map((resource) => (
                            <Grid.Item key={resource.id}>
                                <Card className="max-w-lg">
                                    <Card.Header>
                                        <Card.Title>{resource.name}</Card.Title>
                                    </Card.Header>
                                    <Card.Content>
                                        <p>
                                            Postęp wydobycia:{' '}
                                            {resource.progress || 0} / 10
                                        </p>
                                        <p>Ilość: {resource.value}</p>
                                        <Button
                                            appearance={'outline'}
                                            onClick={() =>
                                                handleResourceClick(resource)
                                            }
                                            className="mt-2"
                                        >
                                            Wydobywaj
                                        </Button>
                                        {flyingBonus[resource.id] && (
                                            <div className="flying-bonus">
                                                +1 {resource.name}
                                            </div>
                                        )}
                                    </Card.Content>
                                </Card>
                            </Grid.Item>
                        ))}
                    </Grid>
                </div>
            </div>
        </GameScreen>
    );
}
