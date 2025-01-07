import {Button, Card, Container, Grid} from '@/components/ui';
import Authenticated from '@/layouts/authenticated-layout';
import {Link, usePage} from '@inertiajs/react';

export default function ChooseCharacter() {
    const {data: characters} = usePage().props.characters; // Extract the data array from the response

    console.log(characters);

    return (
        <Authenticated>
            <Container>
                <div className="flex h-screen flex-col items-center justify-center space-y-4">
                    <Grid columns={3} className="gap-4">
                        {characters.length === 0 ? (
                            // No characters: Show card to create a character
                            <Grid.Item>
                                <Card className="max-w-lg">
                                    <Card.Header>
                                        <Card.Description>
                                            Nie posiadasz jeszcze żadnej postaci
                                        </Card.Description>
                                    </Card.Header>
                                    <Card.Content>
                                        Zacznij przygodę i stwórz pierwszego
                                        bohatera!
                                    </Card.Content>
                                    <Card.Footer>
                                        <Link
                                            href={route(
                                                'games.create-character',
                                            )}
                                        >
                                            <Button appearance="outline">
                                                Stwórz bohatera
                                            </Button>
                                        </Link>
                                    </Card.Footer>
                                </Card>
                            </Grid.Item>
                        ) : (
                            // 1 or more characters: Display existing characters and add character card
                            <>
                                {characters.map((character: any) => (
                                    <Grid.Item key={character.id}>
                                        <Card className="max-w-lg">
                                            <Card.Header>
                                                <Card.Description>
                                                    {character.race}{' '}
                                                    {character.class}
                                                </Card.Description>
                                            </Card.Header>
                                            <Card.Content>
                                                {character.name}
                                            </Card.Content>
                                            <Card.Footer>
                                                <Link
                                                    href={route(
                                                        'games.choose-character',
                                                        [character.id],
                                                    )}
                                                >
                                                    <Button appearance="outline">
                                                        Select {character.name}
                                                    </Button>
                                                </Link>
                                            </Card.Footer>
                                        </Card>
                                    </Grid.Item>
                                ))}
                                {/* Add new character card */}
                                {characters.length < 2 && (
                                    <Grid.Item>
                                        <Card className="max-w-lg">
                                            <Card.Header>
                                                <Card.Description>
                                                    Add a New Character
                                                </Card.Description>
                                            </Card.Header>
                                            <Card.Content>
                                                Expand your team by creating a
                                                new character.
                                            </Card.Content>
                                            <Card.Footer>
                                                <Link
                                                    href={route(
                                                        'games.create-character',
                                                    )}
                                                >
                                                    <Button>
                                                        Create Character
                                                    </Button>
                                                </Link>
                                            </Card.Footer>
                                        </Card>
                                    </Grid.Item>
                                )}
                            </>
                        )}
                    </Grid>
                </div>
            </Container>
        </Authenticated>
    );
}
