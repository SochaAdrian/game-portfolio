import {useTheme} from '@/components/theme-provider';
import {Button} from '@/components/ui';
import {IconMoon, IconSun} from 'justd-icons';

interface Props {
    appearance?: 'plain' | 'outline';
}

export function ThemeSwitcher({appearance = 'plain'}: Props) {
    const {theme, setTheme} = useTheme();
    return (
        <Button
            appearance={appearance}
            size="square-petite"
            aria-label="Switch theme"
            onPress={() => setTheme(theme === 'light' ? 'dark' : 'light')}
        >
            <IconSun className="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"/>
            <IconMoon
                className="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"/>
        </Button>
    );
}
