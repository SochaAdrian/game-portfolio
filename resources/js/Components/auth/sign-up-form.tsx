import {Button, Card, Heading, TextField} from '@/components/ui';
import {useForm} from '@inertiajs/react';
import {FormEventHandler, PropsWithChildren} from 'react';

export default function SignUpForm({children}: PropsWithChildren) {
    const {data, setData, post, processing, errors, reset} = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <Card className={'w-1/2'}>
            <Card.Header>
                <Heading level={3}> Zarejestruj się</Heading>
            </Card.Header>
            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}
            <Card.Content className="space-y-6">
                <form onSubmit={submit}>
                    <div>
                        <TextField
                            errorMessage={errors.name}
                            isInvalid={!!errors.name}
                            validationErrors={errors.name}
                            label={'Nazwa'}
                            id="name"
                            type={'text'}
                            name="name"
                            value={data.name}
                            className="mt-1 block w-full"
                            autoComplete="name"
                            onChange={(e) => {
                                setData('name', e);
                            }}
                            required
                        />
                    </div>

                    <div className="mt-4">
                        <TextField
                            errorMessage={errors.email}
                            isInvalid={!!errors.email}
                            validationErrors={errors.email}
                            label={'Email'}
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            onChange={(e) => {
                                setData('email', e);
                            }}
                            required
                        />
                    </div>

                    <div className="mt-4">
                        <TextField
                            errorMessage={errors.password}
                            isInvalid={!!errors.password}
                            validationErrors={errors.password}
                            description={'Hasło musi mieć co najmniej 8 znaków'}
                            label={'Hasło'}
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => {
                                setData('password', e);
                            }}
                            required
                        />
                    </div>

                    <div className="mt-4">
                        <TextField
                            errorMessage={errors.password_confirmation}
                            isInvalid={!!errors.password_confirmation}
                            validationErrors={errors.password_confirmation}
                            label={'Powtórz hasło'}
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => {
                                setData('password_confirmation', e);
                            }}
                            required
                        />
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <Button
                            appearance="outline"
                            onClick={submit}
                            type={'submit'}
                        >
                            Zarejestruj się
                        </Button>
                    </div>
                </form>
            </Card.Content>
        </Card>
    );
}
