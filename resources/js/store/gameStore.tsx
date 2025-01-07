import {create} from 'zustand';
import {devtools} from 'zustand/middleware';

interface Building {
    id: number;
    name: string;
    description: string;
    building_cost: number;
    building_resource: number;
    building_resource_name: string;
    owned: number;
}

interface GameStoreState {
    localizations: any[];
    quests: any[];
    buildings: Building[];
    statistics: any[];
    localizationNpcs: any[];
    setLocalizations: (localizations: any[]) => void;
    setQuests: (quests: any[]) => void;
    setBuildings: (buildings: Building[]) => void;
    setStatistics: (statistics: any[]) => void;
    setLocalizationNpcs: (localizationNpcs: any[]) => void;
    updateBuildingOwned: (buildingId: number, owned: number) => void;
}

const useGameStore = create<GameStoreState>()(
    devtools(
        (set) => ({
            localizations: [],
            quests: [],
            buildings: [],
            statistics: [],
            localizationNpcs: [],
            setLocalizations: (localizations) => set(() => ({ localizations })),
            setQuests: (quests) => set(() => ({ quests })),
            setBuildings: (buildings) => set(() => ({ buildings })),
            setStatistics: (statistics) => set(() => ({ statistics })),
            setLocalizationNpcs: (localizationNpcs) =>
                set(() => ({ localizationNpcs })),
            updateBuildingOwned: (buildingId, owned) =>
                set((state) => ({
                    buildings: state.buildings.map((building) =>
                        building.id === buildingId
                            ? { ...building, owned } // Update the owned count
                            : building
                    ),
                })),
        }),
        { name: 'GameStore' },
    ),
);

export default useGameStore;
