import { ThemeSwitcher } from '@/components/theme-switcher';
import { Navbar, Separator } from '@/components/ui';
import useGameStore from '@/store/gameStore';
import useResourceStore from '@/store/resourceStore';
import { usePage } from '@inertiajs/react';
import { useEffect } from 'react';


export default function ResourceBar() {
    const auth = usePage().props.auth;
    const resources = useResourceStore((state) => state.resources);
    const setResources = useResourceStore((state) => state.setResources);
    const statistics = useGameStore((state) => state.statistics);
    const character = auth.character.data;

    useEffect(() => {
        window.Echo.private(`user.${auth.user.id}.character.${character.id}`)
            .listen('.resource.updated', (event) => {
                setResources(event.resources)
            });
    }, [auth.user.id, character.id, setResources]);

    return (
        <Navbar intent="navbar" isSticky={true}>
            <Navbar.Nav>
                <Navbar.Section className={"!text-sm"}>
                    Zasoby:
                    {resources.map((resource) => (
                        <Navbar.Item key={resource.id}  className={"!text-sm"}>
                            {resource.name}: {resource.value} (+
                            {resource.generation ?? 0}/s)
                        </Navbar.Item>
                    ))}
                </Navbar.Section>
                <Separator orientation="vertical" className="ml-1 mr-3 h-6" />
                <Navbar.Section className={"!text-sm"}>
                    Statystyki:
                    {statistics.map((statistic) => (
                        <Navbar.Item key={statistic.id}  className={"!text-sm"}>
                            {statistic.name}:{' '}
                            {character.statistics.find(
                                (stat) =>
                                    stat.statistic_name.toLowerCase() ===
                                    statistic.name.toLowerCase(),
                            )?.statistic_value || 0}
                        </Navbar.Item>
                    ))}
                </Navbar.Section>
                <Separator orientation="vertical" className="ml-1 mr-3 h-6" />
                <Navbar.Section className="ml-auto hidden sm:flex">
                    <Navbar.Flex>
                        <ThemeSwitcher />
                    </Navbar.Flex>
                </Navbar.Section>
            </Navbar.Nav>
        </Navbar>
    );
}
