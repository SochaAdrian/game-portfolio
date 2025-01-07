import ErrorAlert from '@/components/shared/error-alert';
import {
    Button,
    Choicebox,
    Container,
    Heading,
    Tabs,
    TextField,
    Textarea,
} from '@/components/ui';
import Authenticated from '@/layouts/authenticated-layout';
import {usePage} from '@inertiajs/react';
import axios from 'axios';
import {useState} from 'react';
import {Selection} from 'react-aria-components';
import {Simulate} from 'react-dom/test-utils';
import submit = Simulate.submit;

export default function createCharacter() {
    const {races, classes} = usePage().props;

    const [selectedRace, setSelectedRace] = useState<Selection>(
        new Set([races[0].id]),
    );
    const [selectedClass, setSelectedClass] = useState<Selection>(null);
    const [characterName, setCharacterName] = useState(null);
    const [characterDescription, setCharacterDescription] = useState(null);
    const [errors, setErrors] = useState<Record<string, string[]>>({});

    const submit = async () => {
        try {
            const selectedRaceId = selectedRace.values().next().value;
            const selectedClassId = selectedClass?.values().next().value;

            if (!characterName || !selectedRaceId || !selectedClassId) {
                setErrors({general: ['All fields must be filled in.']});
                return;
            }

            // Prepare the data
            const data = {
                name: characterName,
                races_id: selectedRaceId,
                classes_id: selectedClassId,
                bio: characterDescription,
            };

            // Get CSRF token
            await axios.get('/sanctum/csrf-cookie');

            // Send the POST request with CSRF protection
            const response = await axios.post(route('characters.store'), data);
            if (response.status === 200 || response.status === 201) {
                window.location.href =
                    response.data.redirect || route('games.index');
            }
        } catch (error) {
            if (error.response && error.response.status === 422) {
                // Validation errors
                setErrors(error.response.data.errors);
            } else {
                // Other errors
                setErrors({general: [error.message]});
            }
        }
    };

    return (
        <Authenticated>
            <Container
                className={'align-center flex max-h-full justify-center py-32'}
                intent="constrained"
            >
                <div>
                    <Tabs
                        orientation={'vertical'}
                        aria-label={'Tworzenie postaci'}
                        className={'h-1/2'}
                    >
                        <Tabs.List>
                            <Tabs.Tab id={'a'}> Wybierz rasę </Tabs.Tab>
                            <Tabs.Tab id={'b'}> Wybierz klasę </Tabs.Tab>
                            <Tabs.Tab id={'c'}> Uzupełnij informacje </Tabs.Tab>
                        </Tabs.List>
                        <Tabs.Panel id={'a'}>
                            <div className="flex flex-col items-center justify-center space-y-4">
                                <Heading className={'mb-4'}>
                                    Wybierz rasę bohatera
                                </Heading>
                                <Choicebox
                                    aria-label="Select race"
                                    selectionMode="single"
                                    items={races}
                                    onSelectionChange={setSelectedRace}
                                >
                                    {(item) => (
                                        <Choicebox.Item
                                            title={item.name}
                                            description={item.race_description}
                                        />
                                    )}
                                </Choicebox>
                            </div>
                        </Tabs.Panel>
                        <Tabs.Panel id={'b'}>
                            <div className="flex flex-col items-center justify-center space-y-4">
                                <Heading className={'mb-4'}>
                                    Wybierz klasę bohatera
                                </Heading>
                                <Choicebox
                                    aria-label="Select class"
                                    selectionMode="single"
                                    items={classes}
                                    onSelectionChange={setSelectedClass}
                                >
                                    {(item) => (
                                        <Choicebox.Item
                                            title={item.name}
                                            description={item.class_description}
                                        />
                                    )}
                                </Choicebox>
                            </div>
                        </Tabs.Panel>
                        <Tabs.Panel id={'c'}>
                            <div
                                className="align-center mx-auto flex w-1/2 flex-col items-center justify-center space-y-4">
                                <Heading className={'mb-4'} level={3}>
                                    Podaj imię bohatera
                                </Heading>
                                <ErrorAlert errors={errors}/>
                                <TextField
                                    label={'Imię bohatera'}
                                    className={'w-full'}
                                    onChange={(e) => setCharacterName(e)}
                                />
                                <Textarea
                                    label={'Opis bohatera'}
                                    className={'w-full'}
                                    onChange={(e) => setCharacterDescription(e)}
                                />
                                <Button onPress={submit} appearance="outline">
                                    Stwórz bohatera
                                </Button>
                            </div>
                        </Tabs.Panel>
                    </Tabs>
                </div>
            </Container>
        </Authenticated>
    );
}
