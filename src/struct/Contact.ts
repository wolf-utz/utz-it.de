export default class Contact {

    private _name: string;

    private _email: string;

    private _message: string;

    public constructor(email: string, message: string, name: string = '') {
        this._email = email;
        this._message = message;
        this._name = name;
    }

    get name(): string {
        return this._name;
    }

    set name(value: string) {
        this._name = value;
    }

    get email(): string {
        return this._email;
    }

    set email(value: string) {
        this._email = value;
    }

    get message(): string {
        return this._message;
    }

    set message(value: string) {
        this._message = value;
    }

    public static fromFromData(formData: FormData): this {
        return new this(
            <String>(formData.get('email') || ''),
            <String>(formData.get('message') || ''),
            <String>(formData.get('name') || ''),
        );
    }

    toJson() : string {
        return JSON.stringify({
            name: this.name,
            email: this.email,
            message: this.message,
        })
    }
}