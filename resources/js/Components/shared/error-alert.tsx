export default function ErrorAlert({
                                       errors,
                                   }: {
    errors: Record<string, string[]>;
}) {
    if (!errors || Object.keys(errors).length === 0) {
        return null;
    }

    return (
        <div
            className="relative mb-4 rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700"
            role="alert"
        >
            <strong className="font-bold">Bład!</strong>
            <ul className="mt-2">
                {Object.entries(errors).map(([field, messages]) => (
                    <li key={field}>
                        <strong>{field}:</strong> {messages.join(', ')}
                    </li>
                ))}
            </ul>
        </div>
    );
}
