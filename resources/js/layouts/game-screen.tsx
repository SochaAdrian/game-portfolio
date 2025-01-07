import Sidebar from '@/components/shared/sidebar';
import {Container} from '@/components/ui';
import Authenticated from '@/layouts/authenticated-layout';
import useGameStore from '@/store/gameStore';
import useResourceStore from '@/store/resourceStore';
import {usePage} from '@inertiajs/react';
import {PropsWithChildren, useEffect} from 'react';

export default function GameScreen({children}: PropsWithChildren) {
    const {auth, gameData} = usePage().props;
    // @ts-ignore
    const character = auth.character.data;

    const {setResources} = useResourceStore();
    const {setLocalizations, setQuests, setBuildings, setStatistics} =
        useGameStore();

    useEffect(() => {
        setResources(character.resources);
        setLocalizations(gameData.localizations.data);
        setQuests(gameData.quests.data);
        setBuildings(gameData.buildings.data);
        setStatistics(gameData.statistics.data);
    }, [
        character.resources,
        setResources,
        gameData.localizations,
        gameData.quests,
        gameData.buildings,
        gameData.statistics,
        setLocalizations,
        setQuests,
        setBuildings,
        setStatistics,
    ]);

    return (
        <Authenticated>
            <Sidebar character={character}>
                <Container>{children}</Container>
            </Sidebar>
        </Authenticated>
    );
}
