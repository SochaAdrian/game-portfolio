import GameScreen from '@/layouts/game-screen';
import useGameStore from '@/store/gameStore';
import useResourceStore from '@/store/resourceStore';
import { Button, Card, Grid, Heading } from '@/components/ui';
import { usePage } from '@inertiajs/react';
import axios from 'axios';
import { useState } from 'react';

export default function Buildings() {
    const { buildings, updateBuildingOwned } = useGameStore();
    const resources = useResourceStore((state) => state.resources);
    const [flyingBuildingBonus, setFlyingBuildingBonus] = useState<Record<number, boolean>>({}); // Track flying animation per building

    async function buildBuilding(building) {
        const requiredResourceId = building.building_resource;
        const requiredCost = building.building_cost;

        const resourceObject = resources.find(
            (resource) => resource.original_id === building.building_resource,
        );

        if (!resourceObject) {
            console.error('Resource not found');
            return;
        }

        const newResourceValue = resourceObject.value - requiredCost;

        // Update resource in the store
        useResourceStore.getState().updateResource(requiredResourceId, newResourceValue);

        // Send the build request to the server
        axios
            .post(route('buildings.build', building.id))
            .then((response) => {
                const { owned } = response.data;
                updateBuildingOwned(building.id, owned);
                setFlyingBuildingBonus((prev) => ({
                    ...prev,
                    [building.id]: true,
                }));
                setTimeout(() => {
                    setFlyingBuildingBonus((prev) => ({
                        ...prev,
                        [building.id]: false,
                    }));
                }, 700);

                console.log(`${building.name} constructed!`);
            })
            .catch((error) => {
                console.error('Failed to build the building:', error);
            });
    }


    function canBuild(building) {
        const requiredResource = resources.find(
            (resource) => resource.original_id === building.building_resource,
        );

        return (
            requiredResource && requiredResource.value >= building.building_cost
        );
    }

    return (
        <GameScreen>
            <Heading>Jako potężny ziemski magnat możesz posiadać budynki na swojej ziemi:</Heading>
            <Grid columns={3} gap={4} className="mt-4">
                {buildings.map((building) => (
                    <Card key={building.id}>
                        <Card.Header>
                            {building.name} {building.owned > 0 && `(${building.owned})`}
                        </Card.Header>
                        <Card.Content>
                            {building.description}
                            <p>
                                Do budowy wymaga: {building.building_cost} x{' '}
                                {building.building_resource_name}
                            </p>
                        </Card.Content>
                        <Card.Footer>
                            <Button
                                appearance="outline"
                                onClick={() => buildBuilding(building)}
                                isDisabled={!canBuild(building)} // Disable if the player doesn't have enough resources
                            >
                                Wybuduj
                            </Button>
                            {flyingBuildingBonus[building.id] && (
                                <div className="flying-bonus">
                                    +1 {building.name}
                                </div>
                            )}
                        </Card.Footer>
                    </Card>
                ))}
            </Grid>
        </GameScreen>
    );
}
