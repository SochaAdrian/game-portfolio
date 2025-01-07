import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export interface Character {
    data: CharacterData;
}

export interface CharacterData {
    id: number;
    name: string;
    race: string;
    class: string;
    buildings: BuildingsData[];
    items: ItemsData[];
    statistics: StatisticsData[];
    quests: QuestsData[];
    resources: ResourceData[];
    localization: string;
    localization_id: number;
    damage_stat: string;
    bio: string;
    appearance: string;
}

export interface StatisticsData {
    id: number;
    statistic_name: string;
    statistic_value: number;
    statistics_id: number;
}

export interface ResourceData {
    id: number;
    value: number;
    name: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    gameData: {
        localizations: { data: any[] };
        quests: { data: any[] };
        buildings: { data: any[] };
        statistics: { data: any[] };
    };
    auth: {
        character: Character | null;
        user: User;
    };
    ziggy: Config & { location: string };
};
