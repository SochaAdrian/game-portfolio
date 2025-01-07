import ResourceBar from '@/components/shared/resource-bar';
import {buttonStyles, Link, Sidebar} from '@/components/ui/';
import {CharacterData} from '@/types';
import {
    IconBuilding,
    IconHome5,
    IconMagicStar,
    IconMap,
    IconSparklesThree,
} from 'justd-icons';
import {PropsWithChildren} from 'react';

interface GameProps extends PropsWithChildren {
    character: CharacterData;
}

export default function SidebarLayout({character, children}: GameProps) {
    return (
        <Sidebar.Provider>
            <Sidebar>
                <Sidebar.Header>
                    <div className="p-4 text-xl font-bold">
                        {character.name}
                    </div>
                </Sidebar.Header>

                <Sidebar.Content>
                    <Sidebar.Section title="Menu gry">
                        <Sidebar.Item
                            icon={IconHome5}
                            href={route('games.game-screen')}
                        >
                            Ekran główny
                        </Sidebar.Item>
                        <Sidebar.Item
                            icon={IconHome5}
                            href={route('games.camp')}
                        >
                            Obóz
                        </Sidebar.Item>
                        <Sidebar.Item icon={IconMap} href={route('games.map')}>
                            Mapa
                        </Sidebar.Item>
                        <Sidebar.Item
                            icon={IconMagicStar}
                            href={route('games.quests')}
                        >
                            Misje
                        </Sidebar.Item>
                        <Sidebar.Item
                            icon={IconBuilding}
                            href={route('games.buildings')}
                        >
                            Budynki
                        </Sidebar.Item>
                        <Sidebar.Item
                            icon={IconSparklesThree}
                            href={route('games.participate')}
                        >
                            Podróż
                        </Sidebar.Item>
                    </Sidebar.Section>
                </Sidebar.Content>

                <Sidebar.Footer>
                    <Link
                        className={buttonStyles({appearance: 'outline'})}
                        href={route('logout')}
                    >
                        Wyloguj się
                    </Link>
                </Sidebar.Footer>
            </Sidebar>
            <Sidebar.Inset>
                <ResourceBar/>
                <div className="@xl:py-12 py-6">{children}</div>
            </Sidebar.Inset>
        </Sidebar.Provider>
    );
}
