import {Button, Table} from '@/components/ui';
import useGameStore from '@/store/gameStore';
import axios from 'axios';
import {PropsWithChildren, useState} from 'react';

export default function MissionBoard({children}: PropsWithChildren) {
    const quests = useGameStore((state) => state.quests);
    const setQuests = useGameStore((state) => state.setQuests);
    const [tableKey, setTableKey] = useState(0); // Key to force table re-render

    console.log('Rendering MissionBoard with quests:', quests);

    const handleStartQuest = async (id: number) => {
        try {
            const response = await axios.post(route('quests.start', [id]));
            if (response.data.success) {
                const updatedQuests = quests.filter((quest) => quest.id !== id);
                setQuests([...updatedQuests]);
                setTableKey((prevKey) => prevKey + 1);

                console.log('Updated quests:', updatedQuests);
            } else {
                console.error(response.data.error);
            }
        } catch (error) {
            console.error('Failed to start the quest:', error);
        }
    };

    return (
        <div>
            <h1 className="mt-8 text-2xl font-semibold">Przyjmij zlecenia</h1>
            <div className="mt-4">
                <Table key={tableKey} aria-label="Products">
                    <Table.Header>
                        <Table.Column className="w-0">#</Table.Column>
                        <Table.Column isRowHeader>Nazwa</Table.Column>
                        <Table.Column>Opis</Table.Column>
                        <Table.Column>Typ</Table.Column>
                        <Table.Column>Nagroda</Table.Column>
                        <Table.Column/>
                    </Table.Header>
                    <Table.Body items={quests}>
                        {(item) => (
                            <Table.Row key={item.id}>
                                <Table.Cell>{item.id}</Table.Cell>
                                <Table.Cell>{item.name}</Table.Cell>
                                <Table.Cell>{item.description}</Table.Cell>
                                <Table.Cell>{item.type}</Table.Cell>
                                <Table.Cell>
                                    {item.rewards.map((reward) => (
                                        <div key={reward.id}>
                                            {reward.resourceName}{' '}
                                            {reward.statisticName}{' '}
                                            {reward.buildingName} x{' '}
                                            {reward.value}
                                        </div>
                                    ))}
                                </Table.Cell>
                                <Table.Cell>
                                    <Button
                                        appearance={"outline"}
                                        onClick={() =>
                                            handleStartQuest(item.id)
                                        }
                                    >
                                        Przyjmij
                                    </Button>
                                </Table.Cell>
                            </Table.Row>
                        )}
                    </Table.Body>
                </Table>
            </div>
        </div>
    );
}
