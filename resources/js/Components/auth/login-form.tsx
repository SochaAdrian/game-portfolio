import {useForm} from '@inertiajs/react';
import {FormEventHandler} from 'react';
import {Button, Card, Checkbox, Heading, TextField} from '../ui';

export default function LoginForm({status}: { status?: string }) {
    const {data, setData, post, processing, errors, reset} = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <Card className={'w-1/2'}>
            <Card.Header>
                <Heading level={3}> Zaloguj się</Heading>
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
                            id="email"
                            type="email"
                            name="email"
                            label={'Email'}
                            value={data.email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            isInvalid={!!errors.email}
                            validationErrors={errors.email}
                            errorMessage={errors.email}
                            isFocused={true}
                            onChange={(e) => {
                                setData('email', e);
                            }}
                        />
                    </div>

                    <div className="mt-4">
                        <TextField
                            id="password"
                            type="password"
                            name="password"
                            label={'Hasło'}
                            value={data.password}
                            errorMessage={errors.password}
                            isInvalid={!!errors.password}
                            validationErrors={errors.password}
                            className="mt-1 block w-full"
                            autoComplete="current-password"
                            onChange={(e) => {
                                setData('password', e);
                            }}
                        />
                    </div>

                    <div className="mt-4 block">
                        <label className="flex items-center">
                            <Checkbox
                                name="remember"
                                label={'Zapamiętaj mnie'}
                                checked={data.remember}
                                onChange={(e) => setData('remember', e)}
                            />
                        </label>
                    </div>

                    <div className="mt-4 flex items-center justify-end">
                        <Button
                            appearance="outline"
                            onPress={submit}
                            type={'submit'}
                        >
                            Zaloguj się
                        </Button>
                    </div>
                </form>
            </Card.Content>
        </Card>
    );
}
