import {Button, Card} from '@/components/ui';
import GameScreen from '@/layouts/game-screen';
import {usePage} from '@inertiajs/react';
import axios from 'axios';
import {useState} from 'react';

export default function ParticipateInQuest() {
    const {questReward, quest, auth, isCompleted} = usePage().props;
    const character = auth.character.data;

    console.log(questReward)

    const [progress, setProgress] = useState<number>(0);
    const [questStatus, setQuestStatus] = useState<string>('W trakcie');

    const damageStatValue =
        character.statistics.find(
            (stat) =>
                stat.statistic_name.toLowerCase() ===
                character.damage_stat.toLowerCase(),
        )?.statistic_value || 0;

    const requirement = quest.requirement;
    const maxProgress = requirement * 100;

    const handleQuestAction = () => {
        const incrementValue = damageStatValue;

        setProgress((prevProgress) => {
            const newProgress = prevProgress + incrementValue;
            if (newProgress >= maxProgress) {
                axios
                    .post(route('games.completeQuest', {id: quest.id}))
                    .then((response) => {
                        setQuestStatus(response.data.quest.status);
                        console.log('Quest completed!', response.data);
                    })
                    .catch((error) => {
                        if (
                            error.response.status === 400 &&
                            error.response.data.error ===
                            'Quest already completed'
                        ) {
                            setQuestStatus('Ukończono');
                            return;
                        }
                        console.error('Error completing quest:', error);
                    });
            }

            return newProgress >= maxProgress ? maxProgress : newProgress;
        });
    };

    return (
        <GameScreen>
            <h1 className="text-2xl font-semibold">
                Twoja misja to: {quest.name}!
            </h1>
            <p>{quest.description}</p>
            {isCompleted ? (
                <div className="mt-4 font-bold text-green-500">
                    Ta misja została już ukończona!
                </div>
            ) : (
                <div>
                    <p>
                        {questReward.data.length > 0 && (
                            <div className={'mt-4'}>
                                Nagroda:
                            </div>
                        )}
                        {questReward.data.map((reward) => (
                            <div key={reward.id}>
                                {reward.resourceName}{' '}
                                {reward.statisticName}{' '}
                                {reward.buildingName} x{' '}
                                {reward.value}
                            </div>
                        ))}
                    </p>
                    <div className="mt-4">
                        <Card>
                            <Card.Header>
                                <Card.Title>Postęp misji</Card.Title>
                            </Card.Header>
                            <Card.Content>
                                <p>
                                    Postęp: {progress} / {maxProgress}
                                </p>
                                <p>Status: {questStatus}</p>
                                <Button
                                    onClick={handleQuestAction}
                                    appearance="outline"
                                >
                                    {quest.type === 'fight' && 'Walcz'}
                                    {quest.type === 'collect' && 'Zdobądź'}
                                    {quest.type === 'find' && 'Szukaj'}
                                </Button>
                            </Card.Content>
                        </Card>
                    </div>
                </div>
            )}
            <p className={"mt-2 text-gray-500 text-sm"}>
                Twoje zadanie to zebrać {maxProgress}{' '}
                {quest.type === 'collect' ? 'przedmiotów' : 'punktów'}{' '}
                {quest.type === 'fight' ? 'walcząc' : 'wykonując zadanie'}
                Twoja postać ze względu na swoje statystyki z każdym kliknieciem zwiększa postęp o {damageStatValue}
            </p>
        </GameScreen>
    );
}
