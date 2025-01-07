import RandomNpc from '@/components/shared/random-npc';
import { Button, Card, Grid, Heading } from '@/components/ui';
import useGameStore from '@/store/gameStore';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useEffect, useState } from 'react';

export default function PeopleBoard() {
    const { localizationNpcs, setLocalizationNpcs } = useGameStore();
    const { auth } = usePage().props;
    // @ts-ignore
    const character = auth.character.data;

    const [chatBubble, setChatBubble] = useState<Record<number, string>>({});

    useEffect(() => {
        if (!character.localization_id) {
            return;
        }

        axios
            .get(route('localization.npc.index', [character.localization_id]))
            .then((response) => {
                setLocalizationNpcs(response.data);
            })
            .catch((error) => {
                console.error('Failed to fetch localization NPCs:', error);
            });
    }, [character.localization_id, setLocalizationNpcs]);

    const sendMeetRequest = (npcId: number) => {
        axios
            .get(route('localization.npc.talk', [npcId]))
            .then((response) => {
                if (response.status === 200) {
                    setChatBubble((prev) => ({
                        ...prev,
                        [npcId]: response.data,
                    }));
                } else if (response.status === 201) {
                    setChatBubble((prev) => ({
                        ...prev,
                        [npcId]: 'You completed the quest!',
                    }));
                }
            })
            .catch((error) => {
                console.error('Failed to talk to NPC:', error);
            });
    };

    if (!character.localization_id) {
        return (
            <div>
                <Heading>Brak NPC do pokazania</Heading>
                <p className="text-gray-500">
                    Twoja postać nie ma przypisanego lokalizacji. Aby spotkać NPC,
                    wyrusz w świat za pomocą mapy.
                </p>
            </div>
        );
    }

    return (
        <div>
            <Heading>Udało Ci się spotkać:</Heading>

            <Grid columns={2} className={'gap-4'}>
                {localizationNpcs.map((npc) => (
                    <Grid.Item className={''} key={'npc' + npc.id}>
                        <Card className="h-full">
                            <Card.Header>
                                <Card.Title>{npc.name}</Card.Title>
                            </Card.Header>
                            <Card.Content className={'flex justify-center'}>
                                <RandomNpc appearance={npc.appearance} />
                            </Card.Content>
                            <Card.Footer className={'flex gap-8'}>
                                <Button
                                    appearance={'outline'}
                                    onClick={() => sendMeetRequest(npc.id)}
                                >
                                    Pogadaj
                                </Button>
                                {chatBubble[npc.id] && (
                                    <div className="chat-bubble">
                                        {chatBubble[npc.id]}
                                    </div>
                                )}
                            </Card.Footer>
                        </Card>
                    </Grid.Item>
                ))}
            </Grid>
        </div>
    );
}
